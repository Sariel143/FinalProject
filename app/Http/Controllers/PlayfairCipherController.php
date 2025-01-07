<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayfairCipherController extends Controller
{
    public function cipher(Request $request)
    {
        $text = strtoupper(trim($request->input('text')));
        $key = trim($request->input('key'));
        $action = $request->input('action'); // 'encrypt' or 'decrypt'

        if (empty($text) || empty($key)) {
            return response()->json(['error' => 'Please enter both text and a key.'], 400);
        }

        $result = $this->playfairCipher($text, $key, $action);

        return response()->json(['result' => $result]);
    }

    private function formatKey($key)
    {
        $key = strtoupper($key);
        $key = preg_replace('/[^A-Z]/', '', $key);
        $key = str_replace('J', 'I', $key);
        return implode('', array_unique(str_split($key)));
    }

    private function createGrid($key)
    {
        $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ"; // J is excluded
        $grid = $this->formatKey($key);
        foreach (str_split($alphabet) as $char) {
            if (strpos($grid, $char) === false) {
                $grid .= $char;
            }
        }
        return $grid;
    }

    private function prepareText($text)
    {
        $text = strtoupper($text);
        $text = preg_replace('/[^A-Z]/', '', $text);
        $text = str_replace('J', 'I', $text);
        $digraphs = [];
        for ($i = 0; $i < strlen($text); $i += 2) {
            $pair = $text[$i];
            if ($i + 1 < strlen($text)) {
                if ($text[$i] === $text[$i + 1]) {
                    $pair = $text[$i] . 'X';
                    $i--;
                } else {
                    $pair = $text[$i] . $text[$i + 1];
                }
            } else {
                $pair = $text[$i] . 'Z';
            }
            $digraphs[] = $pair;
        }
        return $digraphs;
    }

    private function playfairCipher($text, $key, $action)
    {
        $grid = $this->createGrid($key);
        $digraphs = $this->prepareText($text);
        $result = '';

        foreach ($digraphs as $pair) {
            $firstChar = $pair[0];
            $secondChar = $pair[1];
            $firstIdx = strpos($grid, $firstChar);
            $secondIdx = strpos($grid, $secondChar);

            $firstRow = floor($firstIdx / 5);
            $firstCol = $firstIdx % 5;
            $secondRow = floor($secondIdx / 5);
            $secondCol = $secondIdx % 5;

            if ($firstRow === $secondRow) { // Same row
                $result .= $action === 'encrypt' ? $grid[$firstRow * 5 + ($firstCol + 1) % 5] : $grid[$firstRow * 5 + ($firstCol - 1 + 5) % 5];
                $result .= $action === 'encrypt' ? $grid[$secondRow * 5 + ($secondCol + 1) % 5] : $grid[$secondRow * 5 + ($secondCol - 1 + 5) % 5];
            } else if ($firstCol === $secondCol) { // Same column
                $result .= $action === 'encrypt' ? $grid[((($firstRow + 1) % 5)) * 5 + $firstCol] : $grid[((($firstRow - 1 + 5) % 5)) * 5 + $firstCol];
                $result .= $action === 'encrypt' ? $grid[((($secondRow + 1) % 5)) * 5 + $secondCol] : $grid[((($secondRow - 1 + 5) % 5)) * 5 + $firstCol];
            } else { // Rectangle case
                $result .= $grid[$firstRow * 5 + $secondCol];
                $result .= $grid[$secondRow * 5 + $firstCol];
            }
        }

        return $result;
    }
}
