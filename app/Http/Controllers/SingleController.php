<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function process(Request $request)
    {
        $plaintext = strtoupper($request->input('text')); // Ensure the input text is in uppercase
        $key = strtoupper($request->input('key')); // Ensure the key is in uppercase
        $action = $request->input('action'); // 'encrypt' or 'decrypt'

        // Remove spaces from plaintext and key
        $plaintext = str_replace(' ', '', $plaintext);
        $key = str_replace(' ', '', $key);

        // Determine the number of columns based on the length of the key
        $numColumns = strlen($key);
        $numRows = ceil(strlen($plaintext) / $numColumns); // Calculate the required number of rows

        // Pad the plaintext if necessary
        $paddingLength = $numRows * $numColumns - strlen($plaintext);
        if ($paddingLength > 0) {
            $plaintext .= str_repeat('_', $paddingLength); // Padding character
        }

        // Create the grid
        $grid = [];
        $index = 0;
        for ($row = 0; $row < $numRows; $row++) {
            for ($col = 0; $col < $numColumns; $col++) {
                $grid[$row][$col] = $plaintext[$index++];
            }
        }

        // Assign numbers to the key letters
        $keyOrder = $this->getKeyOrder($key);

        // Handle encryption and decryption actions
        if ($action === 'encrypt') {
            // Encrypt: Read the ciphertext based on the key order
            $ciphertext = '';
            foreach ($keyOrder as $columnIndex) {
                for ($row = 0; $row < $numRows; $row++) {
                    $ciphertext .= $grid[$row][$columnIndex];
                }
            }
        } elseif ($action === 'decrypt') {
            // Decrypt: Reverse the encryption process
            $grid = [];
            $ciphertextIndex = 0;

            // Fill the grid with ciphertext
            foreach ($keyOrder as $columnIndex) {
                for ($row = 0; $row < $numRows; $row++) {
                    $grid[$row][$columnIndex] = $plaintext[$ciphertextIndex++];
                }
            }

            // Reconstruct the plaintext from the grid
            $plaintext = '';
            for ($row = 0; $row < $numRows; $row++) {
                for ($col = 0; $col < $numColumns; $col++) {
                    $plaintext .= $grid[$row][$col];
                }
            }

            // Remove padding and return the result
            $ciphertext = rtrim($plaintext, '_');
        }

        // Return the result
        return view('single-tool', compact('ciphertext', 'action', 'key'));
    }

    private function getKeyOrder($key)
    {
        $keyArray = str_split($key);
        asort($keyArray);
        $keyOrder = [];
        foreach ($keyArray as $index => $value) {
            $keyOrder[] = array_search($value, $keyArray);
        }
        return $keyOrder;
    }
}
