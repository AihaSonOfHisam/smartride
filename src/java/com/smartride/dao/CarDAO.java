package com.smartride.dao;

import static com.smartride.dao.DatabaseConnection.getConnection;
import com.smartride.model.Car;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class CarDAO {
    private static final String URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String USER = "app";
    private static final String PASSWORD = "app";
    
    private Connection conn;

    public CarDAO() {
        try {
            conn = DriverManager.getConnection(URL, USER, PASSWORD);
            System.out.println("Database connected successfully!");
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public List<Car> getAllCars() {
        List<Car> cars = new ArrayList<>();
        String query = "SELECT brand, model, colour, plate_num, type, seat_num, transmission, price_per_day, price_per_week, price_per_month, status FROM APP.CAR";
        
        try (PreparedStatement ps = conn.prepareStatement(query);
             ResultSet rs = ps.executeQuery()) {

            while (rs.next()) {
                Car car = new Car(
                    rs.getString("brand"),
                    rs.getString("model"),
                    rs.getString("colour"),
                    rs.getString("plate_num"),
                    rs.getString("type"),
                    rs.getInt("seat_num"),
                    rs.getString("transmission"),
                    rs.getDouble("price_per_day"),
                    rs.getDouble("price_per_week"),
                    rs.getDouble("price_per_month"),
                    rs.getString("status")
                );
                cars.add(car);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return cars;
    }
    
    public Car getCarByPlateNum(String plateNum) {
        Car car = null;
        String query = "SELECT * FROM APP.CAR WHERE plate_num = ?";

        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setString(1, plateNum);
            ResultSet rs = ps.executeQuery();

            if (rs.next()) {
                car = new Car(
                    rs.getString("brand"),
                    rs.getString("model"),
                    rs.getString("colour"),
                    rs.getString("plate_num"),
                    rs.getString("type"),
                    rs.getInt("seat_num"),
                    rs.getString("transmission"),
                    rs.getDouble("price_per_day"),
                    rs.getDouble("price_per_week"),
                    rs.getDouble("price_per_month"),
                    rs.getString("status")
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return car;
    }

    public Car getCarById(int carId) {
        Car car = null;
        String query = "SELECT * FROM APP.CAR WHERE car_id = ?";

        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setInt(1, carId);
            ResultSet rs = ps.executeQuery();

            if (rs.next()) {
                car = new Car(
                    rs.getString("brand"),
                    rs.getString("model"),
                    rs.getString("colour"),
                    rs.getString("plate_num"),
                    rs.getString("type"),
                    rs.getInt("seat_num"),
                    rs.getString("transmission"),
                    rs.getDouble("price_per_day"),
                    rs.getDouble("price_per_week"),
                    rs.getDouble("price_per_month"),
                    rs.getString("status")
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return car;
    }

    public boolean addCar(Car car) {
        String query = "INSERT INTO APP.CAR (brand, model, colour, plate_num, type, seat_num, transmission, price_per_day, price_per_week, price_per_month, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try (PreparedStatement pst = conn.prepareStatement(query)) {
            pst.setString(1, car.getBrand());
            pst.setString(2, car.getModel());
            pst.setString(3, car.getColour());
            pst.setString(4, car.getPlateNum());
            pst.setString(5, car.getType());
            pst.setInt(6, car.getSeatNum());
            pst.setString(7, car.getTransmission());
            pst.setDouble(8, car.getPricePerDay());
            pst.setDouble(9, car.getPricePerWeek());
            pst.setDouble(10, car.getPricePerMonth());
            pst.setString(11, car.getStatus());

            return pst.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    public boolean updateCar(Car car) {
        String query = "UPDATE APP.CAR SET brand=?, model=?, colour=?, type=?, seat_num=?, transmission=?, price_per_day=?, price_per_week=?, price_per_month=?, status=? WHERE plate_num=?";

        try (PreparedStatement pst = conn.prepareStatement(query)) {
            pst.setString(1, car.getBrand());
            pst.setString(2, car.getModel());
            pst.setString(3, car.getColour());
            pst.setString(4, car.getType());
            pst.setInt(5, car.getSeatNum());
            pst.setString(6, car.getTransmission());
            pst.setDouble(7, car.getPricePerDay());
            pst.setDouble(8, car.getPricePerWeek());
            pst.setDouble(9, car.getPricePerMonth());
            pst.setString(10, car.getStatus());
            pst.setString(11, car.getPlateNum());

            int rowsUpdated = pst.executeUpdate();
            System.out.println("Rows updated: " + rowsUpdated);  // Debugging output

            return rowsUpdated > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

     // Delete car from database by plate number
    public boolean deleteCar(String plateNum) {
    String query = "DELETE FROM car WHERE plate_num = ?";
    try (Connection connection = DriverManager.getConnection(URL, USER, PASSWORD);
         PreparedStatement pst = connection.prepareStatement(query)) {

        pst.setString(1, plateNum);
        int result = pst.executeUpdate();

        return result > 0; // Return true if deletion was successful
    } catch (SQLException e) {
        e.printStackTrace();
        return false;
    }
}
}

