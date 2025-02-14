package com.smartride.model;

import java.sql.Date;

public class Reservation {
    private int reservationId;
    private String username;
    private String plateNum;
    private String rentDurationType;
    private int rentDuration;
    private Date startRentDate;
    private String status;

    public Reservation(int reservationId, String username, String plateNum, String rentDurationType, int rentDuration, Date startRentDate, String status) {
        this.reservationId = reservationId;
        this.username = username;
        this.plateNum = plateNum;
        this.rentDurationType = rentDurationType;
        this.rentDuration = rentDuration;
        this.startRentDate = startRentDate;
        this.status = status;
    }

    // Getters
    public int getReservationId() { return reservationId; }
    public String getUsername() { return username; }
    public String getPlateNum() { return plateNum; }
    public String getRentDurationType() { return rentDurationType; }
    public int getRentDuration() { return rentDuration; }
    public Date getStartRentDate() { return startRentDate; }
    public String getStatus() { return status; }

    // Setters
    public void setReservationId(int reservationId) { this.reservationId = reservationId; }
    public void setUsername(String username) { this.username = username; }
    public void setPlateNum(String plateNum) { this.plateNum = plateNum; }
    public void setRentDurationType(String rentDurationType) { this.rentDurationType = rentDurationType; }
    public void setRentDuration(int rentDuration) { this.rentDuration = rentDuration; }
    public void setStartRentDate(Date startRentDate) { this.startRentDate = startRentDate; }
    public void setStatus(String status) { this.status = status; }
}
