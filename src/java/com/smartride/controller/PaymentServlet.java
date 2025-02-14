package com.smartride.controller;

import com.smartride.dao.ReservationDAO;
import com.smartride.model.Reservation;
import java.io.IOException;
import java.sql.*;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/PaymentServlet")
public class PaymentServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private Connection conn;

    public PaymentServlet() {
        try {
            conn = DriverManager.getConnection("jdbc:derby://localhost:1527/SmartRideDB", "app", "app");
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        int reservationId = Integer.parseInt(request.getParameter("reservationId"));
        String cardNumber = request.getParameter("cardNumber");
        String cardholderName = request.getParameter("cardholderName");
        String expirationMonth = request.getParameter("expirationMonth");
        String expirationYear = request.getParameter("expirationYear");
        String cvc = request.getParameter("cvc");

        try {
            // Fetch reservation details
            ReservationDAO reservationDAO = new ReservationDAO();
            Reservation reservation = reservationDAO.getReservationById(reservationId);

            if (reservation == null) {
                response.sendRedirect("error.jsp");
                return;
            }

            // Calculate amount based on rental duration
            double dailyRate = reservationDAO.getCarPrice(reservation.getPlateNum());
            double totalAmount = dailyRate * reservation.getRentDuration();

            // Insert into payment table
            String sql = "INSERT INTO payment (reservation_id, card_number, cardholder_name, expiration_date, cvc, amount) VALUES (?, ?, ?, ?, ?, ?)";
            PreparedStatement ps = conn.prepareStatement(sql);
            ps.setInt(1, reservationId);
            ps.setString(2, cardNumber);
            ps.setString(3, cardholderName);
            ps.setString(4, expirationMonth + "/" + expirationYear);
            ps.setString(5, cvc);
            ps.setDouble(6, totalAmount);

            ps.executeUpdate();

            response.sendRedirect("payment_success.jsp");
        } catch (SQLException e) {
            e.printStackTrace();
            response.sendRedirect("error.jsp");
        }
    }
}
