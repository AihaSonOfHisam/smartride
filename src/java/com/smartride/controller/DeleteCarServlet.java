/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.smartride.controller;

import com.smartride.dao.CarDAO;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class DeleteCarServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    
    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        String plateNum = request.getParameter("plateNum");

        if (plateNum != null && !plateNum.isEmpty()) {
            CarDAO carDAO = new CarDAO();
            boolean isDeleted = carDAO.deleteCar(plateNum);

            if (isDeleted) {
                response.sendRedirect("car.jsp?success=Car deleted successfully");
            } else {
                response.sendRedirect("car.jsp?error=Failed to delete car");
            }
        } else {
            response.sendRedirect("car.jsp?error=Invalid plate number");
        }
    }
}
