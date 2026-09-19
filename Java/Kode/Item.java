public class Item {
    private int id;
    private double price;
    private int stock;

    // constructor kosong
    public Item() {
        this.id = 0;
        this.price = 0.0;
        this.stock = 0;
    }

    // constructor berparameter
    public Item(int id, double price, int stock) {
        this.id = id;
        this.price = price;
        this.stock = stock;
    }

    // getter and setter id
    public void setId(int id) { this.id = id; }
    public int getId() { return id; }

    // getter and setter price
    public void setPrice(double price) { this.price = price; }
    public double getPrice() { return price; }

    // getter and setter stock
    public void setStock(int stock) { this.stock = stock; }
    public int getStock() { return stock; }
}