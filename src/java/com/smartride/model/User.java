package com.smartride.model;

public class User {
    private int id;            // Unique identifier for the user
    private String username;   // Username for login
    private String password;   // User's password
    private String firstName;  // User's first name
    private String lastName;   // User's last name
    private String email;      // User's email address
    private String phoneNumber; // User's phone number
    private String address;    // User's address
    private String gender;     // User's gender
    private String role;       // User's role (e.g., user, admin)

    // Constructor to initialize all fields
    public User(int id, String username, String password, String firstName, String lastName, String email,
                String phoneNumber, String address, String gender, String role) {
        this.id = id;
        this.username = username;
        this.password = password;
        this.firstName = firstName;
        this.lastName = lastName;
        this.email = email;
        this.phoneNumber = phoneNumber;
        this.address = address;
        this.gender = gender;
        this.role = role;
    }

    // Default constructor
    public User() {
        // Empty constructor for creating User objects without pre-populating fields
    }

    public User(String username, String firstName, String lastName, String email, String phoneNum, String address, String gender, String password) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    // Getters and setters for each field

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPhoneNumber() {
        return phoneNumber;
    }

    public void setPhoneNumber(String phoneNumber) {
        this.phoneNumber = phoneNumber;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }
}
