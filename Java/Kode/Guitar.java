public class Guitar extends MusicInstrument {
    private String brand; // Yamaha / Fender / Jackson / Schecter
    private String series; // mis. "Pacifica112"
    private int fretSize; // 24 / 22 / 15 / 12 / 19
    private String stringType; // nilon / nikel / baja / bronze

    // constructor kosong
    public Guitar() {
        super();
        this.brand = "";
        this.series = "";
        this.fretSize = 0;
        this.stringType = "";
    }

    // constructor berparameter (memanggil constructor MusicInstrument lewat super())
    public Guitar(int id, double price, int stock,
                  String playingMethod, String condition, String weight,
                  String brand, String series, int fretSize, String stringType) {
        super(id, price, stock, playingMethod, condition, weight);
        this.brand = brand;
        this.series = series;
        this.fretSize = fretSize;
        this.stringType = stringType;
    }

    // getter and setter brand
    public void setBrand(String brand) { this.brand = brand; }
    public String getBrand() { return brand; }

    // getter and setter series
    public void setSeries(String series) { this.series = series; }
    public String getSeries() { return series; }

    // getter and setter fretSize
    public void setFretSize(int fretSize) { this.fretSize = fretSize; }
    public int getFretSize() { return fretSize; }

    // getter and setter stringType
    public void setStringType(String stringType) { this.stringType = stringType; }
    public String getStringType() { return stringType; }
}