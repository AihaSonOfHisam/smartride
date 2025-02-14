package com.smartride.controller;

import com.smartride.dao.CarDAO;
import com.smartride.model.Car;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/carDetail")
public class CarDetailServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String plateNum = request.getParameter("plateNum");

        if (plateNum != null) {
            CarDAO carDAO = new CarDAO();
            Car car = carDAO.getCarByPlateNum(plateNum);

            if (car != null) {
                request.setAttribute("car", car);
                request.getRequestDispatcher("carDetail.jsp").forward(request, response);
            } else {
                response.sendRedirect("carList.jsp?error=CarNotFound");
            }
        } else {
            response.sendRedirect("carList.jsp?error=InvalidRequest");
        }
    }
}
