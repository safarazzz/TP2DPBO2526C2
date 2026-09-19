#include <bits/stdc++.h>
#include "Guitar.cpp"
using namespace std;

// deklarasi penyingkat dan warna
#define ln    '\n'
typedef vector<Guitar> vg;
typedef Guitar g;
#define RED    "\033[31m"
#define BLUE   "\033[34m"
#define GREEN  "\033[32m"
#define RESET  "\033[0m"

// helper untuk mencetak garis pembatas tabel sesuai lebar tiap kolom
void printLine(const vector<int>& widths) {
    cout << "+";
    for (int w : widths) cout << string(w + 2, '-') << "+";
    cout << ln;
}

// helper untuk mencetak satu baris tabel sesuai lebar tiap kolom
void printRow(const vector<string>& cells, const vector<int>& widths) {
    cout << "|";
    for (size_t i = 0; i < cells.size(); i++) {
        cout << " " << left << setw(widths[i]) << cells[i] << " |";
    }
    cout << ln;
}

// mengubah satu objek Guitar menjadi satu baris data (string) untuk tabel
// menggunakan getter saja, tidak menyentuh atribut private secara langsung
vector<string> guitarToRow(g &item) {
    vector<string> row;
    row.push_back(to_string(item.getId()));
    row.push_back(to_string((long long)item.getPrice()));
    row.push_back(to_string(item.getStock()));
    row.push_back(item.getPlayingMethod());
    row.push_back(item.getCondition());
    row.push_back(item.getWeight());
    row.push_back(item.getBrand());
    row.push_back(item.getSeries());
    row.push_back(to_string(item.getFretSize()));
    row.push_back(item.getStringType());
    return row;
}

// mencetak tabel DINAMIS: lebar tiap kolom dihitung otomatis dari
// panjang data terpanjang di kolom tersebut (termasuk headernya),
// jadi tabel selalu rapi berapapun panjang data yang dimasukkan.
void printDynamicTable(const vector<string> &headers, const vector<vector<string>> &rows) {
    size_t jumlahKolom = headers.size();
    vector<int> width(jumlahKolom, 0);

    // lebar awal tiap kolom diambil dari panjang headernya
    for (size_t c = 0; c < jumlahKolom; c++) {
        width[c] = (int)headers[c].length();
    }

    // perbesar lebar kolom kalau ada data yang lebih panjang dari header
    for (const auto &row : rows) {
        for (size_t c = 0; c < jumlahKolom; c++) {
            if ((int)row[c].length() > width[c]) {
                width[c] = (int)row[c].length();
            }
        }
    }

    printLine(width);
    printRow(headers, width);
    printLine(width);
    for (const auto &row : rows) {
        printRow(row, width);
    }
    printLine(width);
}

// prosedur untuk menampilkan pesan kesalahan ketika daftar gitar masih kosong
void zeroo() {
    cout << RED
         << "Daftar gitar anda masih kosong!" << ln
         << "Tambahkan setidaknya satu gitar untuk menjalankan perintah ini."
         << RESET << ln;
}

// prosedur panduan untuk menampilkan daftar perintah yang tersedia
void panduan() {
    vector<string> headers = {"Perintah", "Format Penggunaan", "Keterangan"};
    vector<vector<string>> rows = {
        {"add",     "add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar)", "Menambahkan satu gitar baru ke daftar."},
        {"show",    "show",    "Menampilkan seluruh gitar dalam tabel dinamis."},
        {"panduan", "panduan", "Menampilkan panduan ini."},
        {"done",    "done",    "Mengakhiri sesi program."}
    };
    cout << "Panduan penggunaan program Toko Gitar" << ln;
    printDynamicTable(headers, rows);
    cout << ln;
}

// prosedur untuk menambahkan gitar baru berdasarkan input satu baris perintah
void add(vg &v, istringstream &iss) {
    int id, stock, fretSize;
    double price, weightNumber;
    string playingMethod, condition, brand, series, stringType;

    if (!(iss >> id >> price >> stock >> playingMethod >> condition
              >> weightNumber >> brand >> series >> fretSize >> stringType)) {
        cout << RED << "Format salah. Gunakan: add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar)" << RESET << ln;
        return;
    }

    // berat disimpan sebagai string supaya satuan "kg" ikut tersimpan
    ostringstream weightStream;
    weightStream << fixed << setprecision(1) << weightNumber << " kg";
    string weight = weightStream.str();

    g temp(id, price, stock, playingMethod, condition, weight, brand, series, fretSize, stringType);
    v.push_back(temp);
    cout << GREEN << "Gitar \"" << brand << " " << series << "\" berhasil ditambahkan dengan id " << id << "." << RESET << ln;
}

// prosedur untuk menampilkan seluruh gitar yang ada di dalam vektor
void show(vg &v) {
    vector<string> headers = {
        "ID", "Harga", "Stok", "CaraMain", "Kondisi",
        "Berat", "Merek", "Seri", "Fret", "Senar"
    };

    vector<vector<string>> rows;
    for (auto &item : v) {
        rows.push_back(guitarToRow(item));
    }

    cout << "Daftar Gitar di Toko:" << ln;
    printDynamicTable(headers, rows);
    cout << "Total gitar: " << v.size() << ln;
}

int main() {
    cout << BLUE << "Selamat datang di Toko Gitar kami!" << RESET << ln;
    cout << "(Ketik 'panduan' untuk menampilkan daftar perintah.)" << ln;

    vg v;

    // 1. data gitar hardcode (5 gitar)
    v.push_back(g(1, 1500000, 24, "dipetik", "baru",    "2.5 kg", "Yamaha",   "Pacifica112",         24, "nikel"));
    v.push_back(g(2, 1200000, 2,  "dipetik", "bekas",   "2.7 kg", "Fender",   "Player Stratocaster", 22, "baja"));
    v.push_back(g(3, 1200000, 9,  "dipetik", "likenew", "5.5 kg", "Jackson",  "JS22 Dinky",          24, "nikel"));
    v.push_back(g(4, 2100000, 5,  "dipetik", "ori",     "3.1 kg", "Schecter", "Omen Elite-6",        22, "baja"));
    v.push_back(g(5, 800000,  12, "dipetik", "premium", "1.9 kg", "Yamaha",   "C40 Classic",         19, "nilon"));

    cout << BLUE << "Apa yang ingin anda lakukan hari ini?" << RESET << ln;

    string commandLine, input;
    bool masih = true;

    while (masih) {
        cout << "|| ";
        if (!getline(cin, commandLine)) break;
        istringstream iss(commandLine);
        if (!(iss >> input)) continue;
        transform(input.begin(), input.end(), input.begin(), ::tolower);

        // kalo done langsung berhenti (exit dari program)
        if (input == "done") {
            masih = false;
        } else {
            bool kosong = v.empty();
            if (input == "add") {
                add(v, iss);
            } else if (input == "show") {
                if (kosong) zeroo();
                else show(v);
            } else if (input == "panduan") {
                panduan();
            } else {
                cout << RED << "Perintah tidak dikenali. Ketik 'panduan' untuk melihat daftar perintah." << RESET << ln;
            }
            cout << BLUE << "Apakah ada yang ingin anda lakukan lagi?" << RESET << ln;
        }
    }

    cout << GREEN << "Terimakasih dan silahkan datang kembali!" << RESET << ln;
    return 0;
}