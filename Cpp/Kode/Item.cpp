#include <bits/stdc++.h>
using namespace std;

class Item{
    private :
        int id;
        double price;
        int stock;
    public :
        // constructor kosong
        Item(){
            id = 0;
            price = 0.0;
            stock = 0;
        };
        // constructor berparameter
        Item(int id, double price, int stock){
            this->id = id;
            this->price = price;
            this->stock = stock;
        }
        // getter and setter id
        void setId(int id){this->id=id;}
        int getId(){return id;}

        // getter and setter price
        void setPrice(double price){this->price=price;}
        double getPrice(){return price;}

        // getter and setter stock
        void setStock(int stock){this->stock=stock;}
        int getStock(){return stock;}

        // destructor (virtual karena kelas ini akan diturunkan)
        virtual ~Item(){}
};