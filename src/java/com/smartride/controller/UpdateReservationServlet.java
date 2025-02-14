package com.smartride.controller;

import com.smartride.dao.ReservationDAO;
import com.smartride.model.Reservation;
import java.io.IOException;
import java.sql.Date;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class UpdateReservationServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        try {
            int reservationId = Integer.parseInt(request.getParameter("reservationId"));
            String username = request.getParameter("username");
            String plateNum = request.getParameter("plateNum");
            String rentDurationType = request.getParameter("rentDurationType");
            int rentDuration = Integer.parseInt(request.getParameter("rentDuration"));
            Date startDate = Date.valueOf(request.getParameter("startDate"));

            Reservation updatedReservation = new Reservation(reservationId, username, plateNum, rentDurationType, rentDuration, startDate, "Pending");

            boolean success = new ReservationDAO().updateReservation(updatedReservation);

            if (success) {
                response.sendRedirect("MyBooking.jsp?update=success");
            } else {
                response.sendRedirect("EditBooking.jsp?reservationId=" + reservationId + "&update=failure");
            }
        } catch (Exception e) {
            e.printStackTrace();
            response.sendRedirect("EditBooking.jsp?update=error");
        }
    }
}
