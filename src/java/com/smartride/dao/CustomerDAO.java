package com.smartride.dao;

import com.smartride.model.Customer;
import com.smartride.util.PasswordUtil;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class CustomerDAO {
    private static final String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String JDBC_USER = "app";
    private static final String JDBC_PASSWORD = "app";

    private static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
    }

    public boolean isUsernameTaken(String username) {
        String sql = "SELECT username FROM CUSTOMERS WHERE username = ?";
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

    public boolean registerCustomer(Customer customer) {
        if (isUsernameTaken(customer.getUsername())) {
            System.out.println("Registration failed: Username already exists.");
            return false;
        }

        String sql = "INSERT INTO CUSTOMERS (username, first_name, last_name, email, phone_num, address, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            String hashedPassword = PasswordUtil.hashPassword(customer.getPassword());

            stmt.setString(1, customer.getUsername());
            stmt.setString(2, customer.getFirstName());
            stmt.setString(3, customer.getLastName());
            stmt.setString(4, customer.getEmail());
            stmt.setString(5, customer.getPhoneNum());
            stmt.setString(6, customer.getAddress());
            stmt.setString(7, customer.getGender());
            stmt.setString(8, hashedPassword);

            int rowsInserted = stmt.executeUpdate();
            System.out.println("Rows inserted into database: " + rowsInserted);
            return rowsInserted > 0;
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Registration failed due to SQL error: " + e.getMessage());
        }
        return false;
    }

    public Customer getCustomerByUsername(String username) {
        String sql = "SELECT * FROM CUSTOMERS WHERE username = ?";
        try (Connection conn = getConnection();
                PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, username);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                return new Customer(
                        rs.getString("username"),
                        rs.getString("first_name"),
                        rs.getString("last_name"),
                        rs.getString("email"),
                        rs.getString("phone_num"),
                        rs.getString("address"),
                        rs.getString("gender"),
                        rs.getString("password") // Might not be needed here
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null; // Return null if user is not found
    }


    public boolean validateLogin(String username, String password) {
        String sql = "SELECT password FROM CUSTOMERS WHERE username = ?";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, username);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                boolean valid = PasswordUtil.verifyPassword(password, rs.getString("password"));
                System.out.println("Login validation for " + username + ": " + valid);
                return valid;
            }
        } catch (SQLException e) {
    e.printStackTrace(); // This prints full SQL error in NetBeans output
    System.out.println("SQL Error: " + e.getMessage());
    }

        return false;
    }
    
    // Fetch all customers
    public List<Customer> getAllCustomers() {
        List<Customer> customers = new ArrayList<>();
        String sql = "SELECT * FROM CUSTOMERS";
        try (Connection conn = getConnection();
                Statement stmt = conn.createStatement();
                ResultSet rs = stmt.executeQuery(sql)) {

            while (rs.next()) {
                Customer customer = new Customer(
                        rs.getString("username"),
                        rs.getString("first_name"),
                        rs.getString("last_name"),
                        rs.getString("password"),
                        rs.getString("email"),
                        rs.getString("phone_num"),
                        rs.getString("address"),
                        rs.getString("gender")
                        
                );
                customers.add(customer);
            }
        } catch (SQLException e) {
            e.printStackTrace();
            throw new RuntimeException("Error fetching all customers", e);
        }
        return customers;
    }

    public boolean addCustomer(Customer customer) {
        String sql = "INSERT INTO CUSTOMERS (username, first_name, last_name, email, phone_num, address, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try (Connection conn = getConnection();
                PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, customer.getUsername());
            stmt.setString(2, customer.getFirstName());
            stmt.setString(3, customer.getLastName());
            stmt.setString(4, customer.getEmail());
            stmt.setString(5, customer.getPhoneNum());
            stmt.setString(6, customer.getAddress());
            stmt.setString(7, customer.getGender());
            stmt.setString(8, customer.getPassword()); // Password already hashed

            int rowsInserted = stmt.executeUpdate();
            return rowsInserted > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    public boolean updateCustomer(Customer customer) {
        String sql = "UPDATE CUSTOMERS SET first_name = ?, last_name = ?, email = ?, phone_num = ?, address = ?, gender = ? WHERE username = ?";
        try (Connection conn = getConnection();
                PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, customer.getFirstName());
            stmt.setString(2, customer.getLastName());
            stmt.setString(3, customer.getEmail());
            stmt.setString(4, customer.getPhoneNum());
            stmt.setString(5, customer.getAddress());
            stmt.setString(6, customer.getGender());
            stmt.setString(7, customer.getUsername());

            int rowsUpdated = stmt.executeUpdate();
            return rowsUpdated > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    public boolean deleteCustomer(String username) {
        String sql = "DELETE FROM CUSTOMERS WHERE username = ?";
        try (Connection conn = getConnection();
                PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, username);
            int rowsDeleted = stmt.executeUpdate();
            return rowsDeleted > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

}


