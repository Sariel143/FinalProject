<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CipherController extends Controller
{
    public function index()
    {
        return view('aes-tool');
    }

    public function process(Request $request)
    {
        $text = $request->input('text');
        $key = $request->input('key');
        $mode = $request->input('mode');
        $cipher = "aes-128-cbc"; // or "aes-256-cbc" if you want stronger encryption

        // Ensure the key length is correct
        if (strlen($key) !== 16 && $cipher === "aes-128-cbc") {
            return back()->with('error', 'Key length must be exactly 16 characters for AES-128.');
        } elseif (strlen($key) !== 32 && $cipher === "aes-256-cbc") {
            return back()->with('error', 'Key length must be exactly 32 characters for AES-256.');
        }

        // Generate a random IV for CBC mode
        $ivLength = openssl_cipher_iv_length($cipher);

        if ($mode === 'encrypt') {
            // Encrypt the text
            $iv = openssl_random_pseudo_bytes($ivLength);
            $encrypted = openssl_encrypt($text, $cipher, $key, 0, $iv);
            $output = base64_encode($iv . $encrypted); // IV is prepended to the encrypted data

            return back()->with([
                'output' => "IV: " . base64_encode($iv) . "\nEncrypted Text: $encrypted\nFinal Output (Base64): $output",
            ]);
        } elseif ($mode === 'decrypt') {
            // Decode the base64 encoded input
            $decodedData = base64_decode($text);
            if ($decodedData === false) {
                return back()->with('error', 'Invalid base64 input.');
            }

            // Extract the IV and encrypted text from the decoded data
            $iv = substr($decodedData, 0, $ivLength);
            $encryptedText = substr($decodedData, $ivLength);

            // Validate the IV length to prevent padding warnings
            if (strlen($iv) !== $ivLength) {
                return back()->with('error', 'Invalid IV length.');
            }

            // Decrypt the text
            $decrypted = openssl_decrypt($encryptedText, $cipher, $key, 0, $iv);
            if ($decrypted === false) {
                return back()->with('error', 'Decryption failed.');
            }

            return back()->with([
                'output' => "IV: " . base64_encode($iv) . "\nEncrypted Text: $encryptedText\nDecrypted Text: $decrypted",
            ]);
        }

        return back()->with('error', 'Invalid mode selected.');
    }
}
