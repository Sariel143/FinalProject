<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaesarCipherController extends Controller
{
    public function showForm()
    {
        return view('caesar-cipher');
    }

    public function processForm(Request $request)
    {
        $request->validate([
            'textInput' => 'required|string',
            'shiftInput' => 'required|integer',
            'action' => 'required|in:encrypt,decrypt',
        ]);

        $textInput = $request->input('textInput');
        $shiftInput = $request->input('shiftInput');
        $action = $request->input('action');

        $result = $this->caesarCipher($textInput, $shiftInput, $action);

        return view('caesar-cipher', compact('textInput', 'shiftInput', 'action', 'result'));
    }

    private function caesarCipher($text, $shift, $action)
    {
        $result = '';
        $shift = ($action === 'decrypt') ? -$shift : $shift; // Negate shift for decryption

        $shift = $shift % 26;

        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];

            if (ctype_alpha($ch)) {
                $base = ctype_upper($ch) ? 'A' : 'a';
                $shiftedChar = chr(((ord($ch) - ord($base) + $shift + 26) % 26) + ord($base));
                $result .= $shiftedChar;
            } else {
                $result .= $ch;
            }
        }

        return $result;
    }
}
