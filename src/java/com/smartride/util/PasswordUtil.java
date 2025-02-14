package com.smartride.util;

import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.security.spec.InvalidKeySpecException;
import java.util.Base64;
import javax.crypto.SecretKeyFactory;
import javax.crypto.spec.PBEKeySpec;

public class PasswordUtil {
    private static final int ITERATIONS = 10000;
    private static final int KEY_LENGTH = 256;
    private static final String ALGORITHM = "PBKDF2WithHmacSHA256";
    private static final int SALT_LENGTH = 16; // 16 bytes salt

    // Generate a random salt
    private static String generateSalt() {
        SecureRandom random = new SecureRandom();
        byte[] salt = new byte[SALT_LENGTH];
        random.nextBytes(salt);
        return Base64.getEncoder().encodeToString(salt);
    }

    // Hash the password with a new salt
    public static String hashPassword(String password) {
        String salt = generateSalt();
        String hashedPassword = hashPasswordWithSalt(password, salt);
        return salt + "$" + hashedPassword; // Store as salt$hash
    }

    // Hash the password using the given salt
    private static String hashPasswordWithSalt(String password, String salt) {
        try {
            PBEKeySpec spec = new PBEKeySpec(password.toCharArray(), Base64.getDecoder().decode(salt), ITERATIONS, KEY_LENGTH);
            SecretKeyFactory factory = SecretKeyFactory.getInstance(ALGORITHM);
            byte[] hash = factory.generateSecret(spec).getEncoded();
            return Base64.getEncoder().encodeToString(hash);
        } catch (NoSuchAlgorithmException | InvalidKeySpecException e) {
            throw new RuntimeException("Error hashing password", e);
        }
    }

    // Verify the entered password against the stored hash
    public static boolean verifyPassword(String enteredPassword, String storedValue) {
        String[] parts = storedValue.split("\\$"); // Split salt and hash
        if (parts.length != 2) {
            throw new IllegalArgumentException("Stored password format is incorrect");
        }
        String salt = parts[0];
        String storedHash = parts[1];

        String enteredHash = hashPasswordWithSalt(enteredPassword, salt);
        return storedHash.equals(enteredHash); // Compare hashes
    }
}
