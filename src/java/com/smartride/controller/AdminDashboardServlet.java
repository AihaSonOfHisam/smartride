import javax.servlet.*;
import javax.servlet.http.*;
import java.io.*;
import java.sql.*;

public class AdminDashboardServlet extends HttpServlet {
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Database connection variables
        String url = "jdbc:derby://localhost:1527/SmartRideDB";
        String username = "app";
        String password = "app";
        
        // SQL queries to get the counts
        String totalReserveQuery = "SELECT COUNT(*) FROM reservation";
        String totalCarQuery = "SELECT COUNT(*) FROM car";
        String totalFeedbackQuery = "SELECT COUNT(*) FROM feedback";
        String totalCustomerQuery = "SELECT COUNT(*) FROM customers";
        
        try (Connection connection = DriverManager.getConnection(url, username, password);
             Statement stmt = connection.createStatement()) {
             
            // Retrieve the counts
            ResultSet reserveResult = stmt.executeQuery(totalReserveQuery);
            ResultSet carResult = stmt.executeQuery(totalCarQuery);
            ResultSet feedbackResult = stmt.executeQuery(totalFeedbackQuery);
            ResultSet customerResult = stmt.executeQuery(totalCustomerQuery);
            
            // Get the count values
            int totalReserve = 0, totalCar = 0, totalFeedback = 0, totalCustomer = 0;
            if (reserveResult.next()) totalReserve = reserveResult.getInt(1);
            if (carResult.next()) totalCar = carResult.getInt(1);
            if (feedbackResult.next()) totalFeedback = feedbackResult.getInt(1);
            if (customerResult.next()) totalCustomer = customerResult.getInt(1);
            
            // Store the counts in session scope
            HttpSession session = request.getSession();
            session.setAttribute("totalReserve", totalReserve);
            session.setAttribute("totalCar", totalCar);
            session.setAttribute("totalFeedback", totalFeedback);
            session.setAttribute("totalCustomer", totalCustomer);
            
            // Redirect to the JSP page
            response.sendRedirect("adminDashboard.jsp");
            
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
