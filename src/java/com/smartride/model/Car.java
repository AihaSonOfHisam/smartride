package com.smartride.model;

public class Car {
    private final String brand;
    private final String model;
    private final String colour;
    private final String plateNum;
    private final String type;
    private final String transmission;
    private final String status;
    private final int seatNum;
    private final double pricePerDay;
    private final double pricePerWeek;
    private final double pricePerMonth;

    // Constructor without imagePath
    public Car(String brand, String model, String colour, String plateNum, 
               String type, int seatNum, String transmission, 
               double pricePerDay, double pricePerWeek, double pricePerMonth, String status) {
        this.brand = brand;
        this.model = model;
        this.colour = colour;
        this.plateNum = plateNum;
        this.type = type;
        this.transmission = transmission;
        this.status = status;
        this.seatNum = seatNum;
        this.pricePerDay = pricePerDay;
        this.pricePerWeek = pricePerWeek;
        this.pricePerMonth = pricePerMonth;
    }

    // Getters
    public String getBrand() { return brand; }
    public String getModel() { return model; }
    public String getColour() { return colour; }
    public String getPlateNum() { return plateNum; }
    public String getType() { return type; }
    public String getTransmission() { return transmission; }
    public String getStatus() { return status; }
    public int getSeatNum() { return seatNum; }
    public double getPricePerDay() { return pricePerDay; }
    public double getPricePerWeek() { return pricePerWeek; }
    public double getPricePerMonth() { return pricePerMonth; }
}
