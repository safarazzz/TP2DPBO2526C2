#include "MusicInstrument.cpp"

class Guitar : public MusicInstrument{
    private :
        string brand;
        string series;
        int fretSize;
        string stringType;
    public :
        // constructor kosong
        Guitar(){
            brand = "";
            series = "";
            fretSize = 0;
            stringType = "";
        };
        // constructor berparameter (memanggil constructor MusicInstrument)
        Guitar(int id, double price, int stock,
               string playingMethod, string condition, string weight,
               string brand, string series, int fretSize, string stringType)
            : MusicInstrument(id, price, stock, playingMethod, condition, weight){
            this->brand = brand;
            this->series = series;
            this->fretSize = fretSize;
            this->stringType = stringType;
        }
        // getter and setter brand
        void setBrand(string brand){this->brand=brand;}
        string getBrand(){return brand;}

        // getter and setter series
        void setSeries(string series){this->series=series;}
        string getSeries(){return series;}

        // getter and setter fretSize
        void setFretSize(int fretSize){this->fretSize=fretSize;}
        int getFretSize(){return fretSize;}

        // getter and setter stringType
        void setStringType(string stringType){this->stringType=stringType;}
        string getStringType(){return stringType;}

        // destructor
        ~Guitar(){}
};