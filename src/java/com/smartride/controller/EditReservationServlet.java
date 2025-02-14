package com.smartride.controller;

import com.smartride.dao.ReservationDAO;
import com.smartride.model.Reservation;

import java.io.IOException;
import java.sql.Date;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class EditReservationServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        int reservationId = Integer.parseInt(request.getParameter("reservationId"));
        String startDate = request.getParameter("startRentDate");
        String status = request.getParameter("status");

        ReservationDAO reservationDAO = new ReservationDAO();
        boolean updated = reservationDAO.updateReservation(reservationId, startDate, status);

        if (updated) {
            response.sendRedirect("MyBooking.jsp?success=updated");
        } else {
            response.sendRedirect("editBooking.jsp?reservationId=" + reservationId + "&error=update_failed");
        }
    }
}
