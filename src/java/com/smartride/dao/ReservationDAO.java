package com.smartride.dao;

import com.smartride.model.Reservation;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ReservationDAO {
    private static final String URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String USER = "app";
    private static final String PASSWORD = "app";
    
    private Connection conn;

    public ReservationDAO() {
        try {
            conn = DriverManager.getConnection(URL, USER, PASSWORD);
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public boolean saveReservation(Reservation reservation) {
        String query = "INSERT INTO APP.RESERVATION (username, plate_num, rent_duration_type, rent_duration, start_rent_date, status) VALUES (?, ?, ?, ?, ?, ?)";
        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setString(1, reservation.getUsername());
            ps.setString(2, reservation.getPlateNum());
            ps.setString(3, reservation.getRentDurationType());
            ps.setInt(4, reservation.getRentDuration());
            ps.setDate(5, reservation.getStartRentDate());
            ps.setString(6, reservation.getStatus());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    public Reservation getReservationById(int reservationId) {
        Reservation reservation = null;
        String query = "SELECT * FROM APP.RESERVATION WHERE reservation_id = ?";
        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setInt(1, reservationId);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                reservation = new Reservation(
                    rs.getInt("reservation_id"),
                    rs.getString("username"),
                    rs.getString("plate_num"),
                    rs.getString("rent_duration_type"),
                    rs.getInt("rent_duration"),
                    rs.getDate("start_rent_date"),
                    rs.getString("status")
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return reservation;
    }

    public double getCarPrice(String plateNum) {
        double price = 0.0;
        String query = "SELECT price_per_day FROM APP.CAR WHERE plate_num = ?";
        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setString(1, plateNum);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                price = rs.getDouble("price_per_day");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return price;
    }

    public List<Reservation> getReservationsByUsername(String username) {
        List<Reservation> reservations = new ArrayList<>();
        String query = "SELECT * FROM APP.RESERVATION WHERE username = ?";
        try (PreparedStatement ps = conn.prepareStatement(query)) {
            ps.setString(1, username);
            ResultSet rs = ps.executeQuery();
            while (rs.next()) {
                reservations.add(new Reservation(
                    rs.getInt("reservation_id"),
                    rs.getString("username"),
                    rs.getString("plate_num"),
                    rs.getString("rent_duration_type"),
                    rs.getInt("rent_duration"),
                    rs.getDate("start_rent_date"),
                    rs.getString("status")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return reservations;
    }

    public boolean updateReservation(Reservation reservation) {
        String query = "UPDATE APP.RESERVATION SET username = ?, plate_num = ?, rent_duration_type = ?, rent_duration = ?, start_rent_date = ?, status = ? WHERE reservation_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setString(1, reservation.getUsername());
            stmt.setString(2, reservation.getPlateNum());
            stmt.setString(3, reservation.getRentDurationType());
            stmt.setInt(4, reservation.getRentDuration());
            stmt.setDate(5, reservation.getStartRentDate());
            stmt.setString(6, reservation.getStatus());
            stmt.setInt(7, reservation.getReservationId());
            return stmt.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }


    public List<Reservation> getAllReservations() {
        List<Reservation> reservations = new ArrayList<>();
        String query = "SELECT * FROM APP.RESERVATION";
        try (Statement stmt = conn.createStatement(); ResultSet rs = stmt.executeQuery(query)) {
            while (rs.next()) {
                reservations.add(new Reservation(
                    rs.getInt("reservation_id"),
                    rs.getString("username"),
                    rs.getString("plate_num"),
                    rs.getString("rent_duration_type"),
                    rs.getInt("rent_duration"),
                    rs.getDate("start_rent_date"),
                    rs.getString("status")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return reservations;
    }

    public void deleteReservation(int reservationId) {
        String query = "DELETE FROM APP.RESERVATION WHERE reservation_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setInt(1, reservationId);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public void verifyReservation(int reservationId) {
        String query = "UPDATE APP.RESERVATION SET status = 'returned' WHERE reservation_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setInt(1, reservationId);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
