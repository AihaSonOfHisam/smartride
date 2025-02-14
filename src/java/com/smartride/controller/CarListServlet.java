package com.smartride.controller;

import com.smartride.dao.CarDAO;
import com.smartride.model.Car;
import java.io.IOException;
import java.util.List;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/carlist")
public class CarListServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        CarDAO carDAO = new CarDAO();
        List<Car> carList = carDAO.getAllCars();
        
        System.out.println("Total Cars Retrieved in Servlet: " + carList.size()); // Debugging

        request.setAttribute("carList", carList);
        request.getRequestDispatcher("carList.jsp").forward(request, response);
    }
}
