package com.smartride.controller;

import com.smartride.dao.AdminDAO;
import com.smartride.model.Admin;
import java.io.IOException;
import javax.servlet.ServletException;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


public class AdminLoginServlet extends HttpServlet {
    
    /**
     *
     * @param request
     * @param response
     * @throws ServletException
     * @throws IOException
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        
        boolean isValid = new AdminDAO().validateLogin(username, password);
        
        if (isValid) {
            // Retrieve admin details
            Admin admin = new AdminDAO().getAdminByUsername(username);
            
            // Create session
            HttpSession session = request.getSession(true);
            session.setAttribute("admin", admin);
            
            System.out.println("Login successful for admin: " + username);
            response.sendRedirect("adminDashboard.jsp"); // Redirect to admin dashboard
        } else {
            System.out.println("Login failed for admin: " + username);
            
            // Redirect to login page with error message
            response.sendRedirect("Login/LoginAdmin.jsp?error=Invalid username or password");
        }
    }
}
