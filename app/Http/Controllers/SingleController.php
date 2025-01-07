<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleToolController extends Controller
{
    private function replaceSpacesWithUnderscore($text)
    {
        return str_replace(' ', '_', $text);
    }

    private function singleColumnarCipher($text, $key, $action)
    {
        $text = $this->replaceSpacesWithUnderscore($text);
        $keyLength = strlen($key);
        $gridHeight = ceil(strlen($text) / $keyLength);
        $grid = array_fill(0, $gridHeight, array_fill(0, $keyLength, ''));

        if ($action === 'encrypt') {
            $index = 0;
            for ($r = 0; $r < $gridHeight; $r++) {
                for ($c = 0; $c < $keyLength; $c++) {
                    $grid[$r][$c] = $index < strlen($text) ? $text[$index++] : '_';
                }
            }

            $sortedKey = str_split($key);
            asort($sortedKey);
            $sortedKey = array_values($sortedKey);

            $result = '';
            foreach ($sortedKey as $char) {
                $colIndex = strpos($key, $char);
                for ($r = 0; $r < $gridHeight; $r++) {
                    $result .= $grid[$r][$colIndex];
                }
            }

            return [
                'result' => $result,
                'grid' => $grid
            ];
        } elseif ($action === 'decrypt') {
            $sortedKey = str_split($key);
            asort($sortedKey);
            $sortedKey = array_values($sortedKey);

            $cipherText = $text;
            $index = 0;
            foreach ($sortedKey as $char) {
                $colIndex = strpos($key, $char);
                for ($r = 0; $r < $gridHeight; $r++) {
                    $grid[$r][$colIndex] = $index < strlen($cipherText) ? $cipherText[$index++] : '_';
                }
            }

            $result = '';
            for ($r = 0; $r < $gridHeight; $r++) {
                for ($c = 0; $c < $keyLength; $c++) {
                    $result .= $grid[$r][$c];
                }
            }

            return [
                'result' => str_replace('_', ' ', $result),
                'grid' => $grid
            ];
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'key' => 'required|string',
            'action' => 'required|in:encrypt,decrypt',
        ]);

        $text = $request->input('text');
        $key = $request->input('key');
        $action = $request->input('action');

        $cipherOutput = $this->singleColumnarCipher($text, $key, $action);

        return response()->json($cipherOutput);
    }
}
