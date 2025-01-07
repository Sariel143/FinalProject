<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VigenereCipherController extends Controller
{
    // Vigenère Cipher Logic
    public function vigenereCipher($text, $key, $action)
    {
        $text = strtoupper($text); // Convert text to uppercase
        $key = strtoupper($key);   // Convert key to uppercase
        $result = '';
        $keyIndex = 0;
        $keyLength = strlen($key);

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            if (ctype_alpha($char)) { // Process alphabetic characters only
                $shift = ord($key[$keyIndex % $keyLength]) - ord('A'); // Calculate shift based on key character

                if ($action === 'encrypt') {
                    $newCharCode = ((ord($char) - ord('A') + $shift) % 26) + ord('A'); // Encrypt
                } elseif ($action === 'decrypt') {
                    $newCharCode = ((ord($char) - ord('A') - $shift + 26) % 26) + ord('A'); // Decrypt
                }

                $result .= chr($newCharCode);
                $keyIndex++;
            } else {
                $result .= $char; // Non-alphabet characters remain unchanged
            }
        }

        return $result;
    }

    // Handle Form Submission
    public function processCipher(Request $request)
    {
        $text = $request->input('text');
        $key = $request->input('key');
        $action = $request->input('action');

        if (!empty($text) && !empty($key)) {
            $result = $this->vigenereCipher($text, $key, $action);

            return response()->json([
                'status' => 'success',
                'result' => $result
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Both text and key are required.'
        ]);
    }
}
