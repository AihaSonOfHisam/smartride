package com.smartride.dao;

import com.smartride.model.Admin;
import com.smartride.util.PasswordUtil;
import java.sql.*;

public class AdminDAO {
    private static final String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String JDBC_USER = "app";
    private static final String JDBC_PASSWORD = "app";

    private static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
    }

    public boolean isUsernameTaken(String username) {
        String sql = "SELECT username FROM ADMIN WHERE username = ?";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, username);
            ResultSet rs = stmt.executeQuery();
            boolean exists = rs.next();
            System.out.println("Checking username: " + username + " exists? " + exists);
            return exists;
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Error checking username: " + e.getMessage());
        }
        return false;
    }

    public boolean registerAdmin(Admin admin) {
        if (isUsernameTaken(admin.getUsername())) {
            System.out.println("Registration failed: Username already exists.");
            return false;
        }

        String sql = "INSERT INTO ADMIN (username, password, email, phone_num, address, gender, ic) VALUES (?, ?, ?, ?, ?, ?, ?)";

        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            String hashedPassword = PasswordUtil.hashPassword(admin.getPassword());

            stmt.setString(1, admin.getUsername());
            stmt.setString(2, hashedPassword);
            stmt.setString(3, admin.getEmail());
            stmt.setString(4, admin.getPhoneNum());
            stmt.setString(5, admin.getAddress());
            stmt.setString(6, admin.getGender());
            stmt.setString(7, admin.getIc());

            int rowsInserted = stmt.executeUpdate();
            System.out.println("Rows inserted into database: " + rowsInserted);
            return rowsInserted > 0;
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Registration failed due to SQL error: " + e.getMessage());
        }
        return false;
    }

    public Admin getAdminByUsername(String username) {
        String sql = "SELECT * FROM ADMIN WHERE username = ?";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, username);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                return new Admin(
                        rs.getString("username"),
                        rs.getString("password_hash"),
                        rs.getString("email"),
                        rs.getString("phone_num"),
                        rs.getString("address"),
                        rs.getString("gender"),
                        rs.getString("ic")
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Error retrieving admin: " + e.getMessage());
        }
        return null;
    }

   public boolean validateLogin(String username, String password) {
    String sql = "SELECT password FROM admin WHERE username = ?";
    try (Connection conn = getConnection();
         PreparedStatement stmt = conn.prepareStatement(sql)) {
        stmt.setString(1, username);
        ResultSet rs = stmt.executeQuery();

        if (rs.next()) {
            String storedPassword = rs.getString("password");
            return PasswordUtil.verifyPassword(password, storedPassword); // Assuming you're using PasswordUtil for hashing
        } else {
            return false;  // No user found with that username
        }
    } catch (SQLException e) {
        e.printStackTrace();
        System.out.println("SQL error in login validation: " + e.getMessage());
    }
    return false;  // Return false in case of error
}

}
