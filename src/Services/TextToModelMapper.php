<?php

namespace Ruslanovich\DateConverter\Services;

use Exception;
use Ruslanovich\DateConverter\Exceptions\IntervalNotFoundException;
use Ruslanovich\DateConverter\Models\DateIntervalCollection;
use Ruslanovich\DateConverter\Models\DateIntervalModel;
use Ruslanovich\DateConverter\Models\DateModel;
use Ruslanovich\DateConverter\Models\DateCollection;
use Ruslanovich\DateConverter\Models\PatternModel;
use Ruslanovich\DateConverter\Models\TextAllPatternMatches;
use Ruslanovich\DateConverter\Models\TextIntervalMatch;
use Ruslanovich\DateConverter\Models\TextPatternMatch;
use Ruslanovich\DateConverter\Models\TextPatternSequence;
use Ruslanovich\DateConverter\Storages\PatternStorages\PatternStorageInterface;

class TextToModelMapper implements TextToModelMapperInterface
{
    private PatternStorageInterface $patternStorage;

    /**
     * @param PatternStorageInterface $patternStorage
     */
    public function __construct(PatternStorageInterface $patternStorage)
    {
        $this->patternStorage = $patternStorage;
    }

    /**
     * @inheritdoc
     */
    public function mapEachPatternSeparately(string $text): TextPatternSequence
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $textPatternSequence = new TextPatternSequence();
        $allDatePatterns = $this->patternStorage->getPatternCollection()->getPatternModels();
        foreach ($allDatePatterns as $datePattern) {
            if (preg_match('/' . $datePattern->getPattern() . '/ui', $text)) {
                $textPatternMatch = $this->generateTextPatternMatch($text, $datePattern);
                $textPatternSequence->add($textPatternMatch);
            }
        }

        return $textPatternSequence;
    }

    /**
     * @inheritdoc
     */
    public function mapAllPatternsTogether(string $text): TextAllPatternMatches
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $textAllPatternMatches = new TextAllPatternMatches();
        $textAllPatternMatches->setOriginalText($text);
        $allDatePatterns = $this->patternStorage->getPatternCollection()->getPatternModels();
        foreach ($allDatePatterns as $datePattern) {
            if (preg_match_all('/' . $datePattern->getPattern() . '/ui', $text, $matches)) {
                $dateModelCollection = new DateCollection();
                foreach ($matches[0] as $row) {
                    $dateModel = $this->formatDateModel($row, $datePattern);
                    $dateModelCollection->addDateModel($dateModel);
                }
                $textAllPatternMatches->addPatternDatesMatch($datePattern, $dateModelCollection);

                $textWithMatches = preg_replace('/' . $datePattern->getPattern() . '/ui', '$pattern_' . $datePattern->getId(), $text);
                $textAllPatternMatches->setTextWithMatches($textWithMatches);
                $text = $textWithMatches;
            }
        }

        return $textAllPatternMatches;
    }

    /**
     * @inheritdoc
     * @throws IntervalNotFoundException
     */
    public function mapToInterval(string $text, string $initialWord, string $separator): TextIntervalMatch
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $allDatePatterns = $this->patternStorage->getPatternCollection()->getPatternModels();

        foreach ($allDatePatterns as $initialPattern) {
            foreach ($allDatePatterns as $finalPattern) {
                $intervalPattern = '/' . $initialWord . $initialPattern->getPattern() . $separator . $finalPattern->getPattern() . '/ui';
                if (preg_match_all($intervalPattern, $text, $matches)) {
                    $intervalCollection = new DateIntervalCollection();
                    foreach ($matches[0] as $row) {
                        $intervalParts = $this->getIntervalParts($row, $initialWord, $separator);
                        $intervalCollection->add(
                            new DateIntervalModel(
                                initialDate: $this->formatDateModel($intervalParts[0], $initialPattern),
                                finalDate: $this->formatDateModel($intervalParts[1], $finalPattern)
                            )
                        );
                    }

                    return new TextIntervalMatch(
                        intervalPattern: $intervalPattern,
                        originalText: $text,
                        textWithMatches: preg_replace($intervalPattern, '$interval', $text),
                        dateIntervalCollection: $intervalCollection
                    );
                }
            }
        }

        throw IntervalNotFoundException::create();
    }

    /**
     * @param string $row
     * @param string $initialWord
     * @param string $separator
     * @return array
     * @throws Exception
     */
    private function getIntervalParts(string $row, string $initialWord, string $separator): array
    {
        /** remove initial word */
        $initialWordsPattern = '/^(' . $initialWord . ')(.*)/';
        if (preg_match($initialWordsPattern, $row)) {
            $row = preg_replace($initialWordsPattern, '$2', $row);
        }

        $inputParts = explode($separator, $row);
        if (count($inputParts) === 2) {
            return $inputParts;
        }

        throw new Exception("interval division error for row: " . $row);
    }

    /**
     * @param string $text
     * @param PatternModel $datePattern
     * @return TextPatternMatch
     */
    private function generateTextPatternMatch(string $text, PatternModel $datePattern): TextPatternMatch
    {
        preg_match_all('/' . $datePattern->getPattern() . '/ui', $text, $matches);
        $allMatchRows = $matches[0];
        $textWithMatches = preg_replace('/' . $datePattern->getPattern() . '/ui', '$pattern_' . $datePattern->getId(), $text);
        $dateModelCollection = new DateCollection();
        foreach ($allMatchRows as $row) {
            $dateModel = $this->formatDateModel($row, $datePattern);
            $dateModelCollection->addDateModel($dateModel);
        }

        return new TextPatternMatch(
            pattern: $datePattern,
            originalText: $text,
            textWithMatches: $textWithMatches,
            dateModelCollection: $dateModelCollection
        );
    }

    /**
     * @param string $row
     * @param PatternModel $patternModel
     * @return DateModel
     */
    private function formatDateModel(string $row, PatternModel $patternModel): DateModel
    {
        preg_match_all('/' . $patternModel->getPattern() . '/ui', $row, $matches);
        $day = $patternModel->getDayPlace() ? (int)$matches[$patternModel->getDayPlace()][0] : null;
        $year = $patternModel->getYearPlace() ? (int)$matches[$patternModel->getYearPlace()][0] : null;

        $monthName = $patternModel->getMonthPlace() ? $matches[$patternModel->getMonthPlace()][0] : null;
        $monthNumber = $this->patternStorage->getMonthNumber($monthName ?? '');

        return new DateModel($day, $monthNumber, $year);
    }
}