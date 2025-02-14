package com.smartride.controller;

import com.smartride.dao.CarDAO;
import com.smartride.model.Car;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

public class AddCarServlet extends HttpServlet {

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Get form parameters
        String brand = request.getParameter("brand");
        String model = request.getParameter("model");
        String colour = request.getParameter("colour");
        String plateNum = request.getParameter("plateNum");
        String type = request.getParameter("type");
        int seatNum = Integer.parseInt(request.getParameter("seatNum"));
        String transmission = request.getParameter("transmission");

        // Check if price parameters are null or empty before parsing
        double pricePerDay = parseDouble(request.getParameter("pricePerDay"));
        double pricePerWeek = parseDouble(request.getParameter("pricePerWeek"));
        double pricePerMonth = parseDouble(request.getParameter("pricePerMonth"));
        
        String status = request.getParameter("status");

        // Create Car object (without image)
        Car newCar = new Car(brand, model, colour, plateNum, type, seatNum, transmission, 
                             pricePerDay, pricePerWeek, pricePerMonth, status);

        // Add car to the database using CarDAO
        CarDAO carDAO = new CarDAO();
        boolean isAdded = carDAO.addCar(newCar);

        if (isAdded) {
            response.sendRedirect("car.jsp"); // Redirect to car list page
        } else {
            response.getWriter().println("Error adding car. Please try again.");
        }
    }

    // Helper method to safely parse double values and avoid NumberFormatException
    private double parseDouble(String value) {
        try {
            return (value != null && !value.trim().isEmpty()) ? Double.parseDouble(value) : 0.0;
        } catch (NumberFormatException e) {
            return 0.0;
        }
    }
}
