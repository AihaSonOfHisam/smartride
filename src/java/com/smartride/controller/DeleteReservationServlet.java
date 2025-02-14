package com.smartride.controller;

import com.smartride.dao.ReservationDAO;
import java.io.IOException;
import javax.servlet.ServletException;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class DeleteReservationServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        int reservationId = Integer.parseInt(request.getParameter("reservationId"));
        
        ReservationDAO reservationDAO = new ReservationDAO();
        reservationDAO.deleteReservation(reservationId);
        
        response.sendRedirect("MyBooking.jsp"); // Redirect back to reservations page
    }
}
