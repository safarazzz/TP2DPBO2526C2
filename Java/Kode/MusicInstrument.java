public class MusicInstrument extends Item {
    private String playingMethod; // dipukul / ditabuh / dipetik
    private String condition; // likenew / baru / bekas / ori / premium
    private String weight; // weight disimpan sebagai String supaya ikut satuan "kg"

    // constructor kosong
    public MusicInstrument() {
        super(); // memanggil constructor kosong milik Item
        this.playingMethod = "";
        this.condition = "";
        this.weight = "";
    }

    // constructor berparameter (memanggil constructor Item lewat super())
    public MusicInstrument(int id, double price, int stock,
                            String playingMethod, String condition, String weight) {
        super(id, price, stock);
        this.playingMethod = playingMethod;
        this.condition = condition;
        this.weight = weight;
    }

    // getter and setter playingMethod
    public void setPlayingMethod(String playingMethod) { this.playingMethod = playingMethod; }
    public String getPlayingMethod() { return playingMethod; }

    // getter and setter condition
    public void setCondition(String condition) { this.condition = condition; }
    public String getCondition() { return condition; }

    // getter and setter weight
    public void setWeight(String weight) { this.weight = weight; }
    public String getWeight() { return weight; }
}