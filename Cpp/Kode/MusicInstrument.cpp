#include "Item.cpp"

class MusicInstrument : public Item{
    private :
        string playingMethod; // dipukul / ditabuh / dipetik
        string condition; // likenew / baru / bekas / ori / premium
        string weight; // weight disimpan sebagai string supaya ikut satuan "kg"
    public :
        // constructor kosong
        MusicInstrument(){
            playingMethod = "";
            condition = "";
            weight = "";
        };
        // constructor berparameter (memanggil constructor Item lewat inisialisasi list)
        MusicInstrument(int id, double price, int stock,
                         string playingMethod, string condition, string weight)
            : Item(id, price, stock){
            this->playingMethod = playingMethod;
            this->condition = condition;
            this->weight = weight;
        }
        // getter and setter playingMethod
        void setPlayingMethod(string playingMethod){this->playingMethod=playingMethod;}
        string getPlayingMethod(){return playingMethod;}

        // getter and setter condition
        void setCondition(string condition){this->condition=condition;}
        string getCondition(){return condition;}

        // getter and setter weight
        void setWeight(string weight){this->weight=weight;}
        string getWeight(){return weight;}

        // destructor
        virtual ~MusicInstrument(){}
};