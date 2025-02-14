package com.smartride.controller;

import com.smartride.dao.CarDAO;
import com.smartride.model.Car;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class EditCarServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        try {
            // Retrieve parameters safely
            String plateNum = request.getParameter("plateNum");
            String brand = request.getParameter("brand");
            String model = request.getParameter("model");
            String colour = request.getParameter("colour");
            String type = request.getParameter("type");
            int seatNum = parseInt(request.getParameter("seatNum"));
            String transmission = request.getParameter("transmission");
            double pricePerDay = parseDouble(request.getParameter("pricePerDay"));
            double pricePerWeek = parseDouble(request.getParameter("pricePerWeek"));
            double pricePerMonth = parseDouble(request.getParameter("pricePerMonth"));
            String status = request.getParameter("status");

            // Debugging output
            System.out.println("Updating car: " + plateNum + ", " + brand + ", " + model);
            
            // Ensure plateNum is valid
            if (plateNum == null || plateNum.trim().isEmpty()) {
                response.sendRedirect("editCar.jsp?error=Plate number is required");
                return;
            }

            // Create a Car object (ensure correct order of parameters)
            Car car = new Car(brand, model, colour, plateNum, type, seatNum, transmission, pricePerDay, pricePerWeek, pricePerMonth, status);

            // Update car in the database
            CarDAO carDAO = new CarDAO();
            boolean success = carDAO.updateCar(car);

            if (success) {
                response.sendRedirect("car.jsp?success=Car updated successfully");
            } else {
                response.sendRedirect("editCar.jsp?plateNum=" + plateNum + "&error=Update failed");
            }
        } catch (Exception e) {
            e.printStackTrace();
            response.sendRedirect("editCar.jsp?error=Internal server error");
        }
    }

    // Helper methods for safe parsing
    private int parseInt(String value) {
        try {
            return (value != null && !value.trim().isEmpty()) ? Integer.parseInt(value) : 0;
        } catch (NumberFormatException e) {
            return 0;
        }
    }

    private double parseDouble(String value) {
        try {
            return (value != null && !value.trim().isEmpty()) ? Double.parseDouble(value) : 0.0;
        } catch (NumberFormatException e) {
            return 0.0;
        }
    }
}
