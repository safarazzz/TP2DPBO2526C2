from Guitar import Guitar

# deklarasi penyingkat dan warna
RED = "\033[31m"
BLUE = "\033[34m"
GREEN = "\033[32m"
RESET = "\033[0m"

# helper untuk mencetak garis pembatas tabel sesuai lebar tiap kolom
def print_line(widths):
    line = "+"
    for w in widths:
        line += "-" * (w + 2) + "+"
    print(line)

# helper untuk mencetak satu baris tabel sesuai lebar tiap kolom
def print_row(cells, widths):
    line = "|"
    for cell, w in zip(cells, widths):
        line += " " + cell.ljust(w) + " |"
    print(line)

# mengubah satu objek Guitar menjadi satu baris data (string) untuk tabel
# menggunakan getter saja, tidak menyentuh atribut private secara langsung
def guitar_to_row(item):
    row = []
    row.append(str(item.get_id()))
    row.append(str(int(item.get_price())))
    row.append(str(item.get_stock()))
    row.append(item.get_playing_method())
    row.append(item.get_condition())
    row.append(item.get_weight())
    row.append(item.get_brand())
    row.append(item.get_series())
    row.append(str(item.get_fret_size()))
    row.append(item.get_string_type())
    return row


# mencetak tabel DINAMIS: lebar tiap kolom dihitung otomatis dari
# panjang data terpanjang di kolom tersebut (termasuk headernya),
# jadi tabel selalu rapi berapapun panjang data yang dimasukkan.
def print_dynamic_table(headers, rows):
    jumlah_kolom = len(headers)
    width = [len(h) for h in headers]

    # perbesar lebar kolom kalau ada data yang lebih panjang dari header
    for row in rows:
        for c in range(jumlah_kolom):
            if len(row[c]) > width[c]:
                width[c] = len(row[c])

    print_line(width)
    print_row(headers, width)
    print_line(width)
    for row in rows:
        print_row(row, width)
    print_line(width)


# prosedur untuk menampilkan pesan kesalahan ketika daftar gitar masih kosong
def zeroo():
    print(RED + "Daftar gitar anda masih kosong!")
    print("Tambahkan setidaknya satu gitar untuk menjalankan perintah ini." + RESET)


# prosedur panduan untuk menampilkan daftar perintah yang tersedia
def panduan():
    headers = ["Perintah", "Format Penggunaan", "Keterangan"]
    rows = [
        ["add", "add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar)",
         "Menambahkan satu gitar baru ke daftar."],
        ["show", "show", "Menampilkan seluruh gitar dalam tabel dinamis."],
        ["panduan", "panduan", "Menampilkan panduan ini."],
        ["done", "done", "Mengakhiri sesi program."]
    ]
    print("Panduan penggunaan program Toko Gitar")
    print_dynamic_table(headers, rows)
    print()


# prosedur untuk menambahkan gitar baru berdasarkan input satu baris perintah
def add(v, tokens):
    try:
        id_ = int(tokens[0])
        price = float(tokens[1])
        stock = int(tokens[2])
        playing_method = tokens[3]
        condition = tokens[4]
        weight_number = float(tokens[5])
        brand = tokens[6]
        series = tokens[7]
        fret_size = int(tokens[8])
        string_type = tokens[9]
    except (IndexError, ValueError):
        print(RED + "Format salah. Gunakan: add (id) (harga) (stok) (caraMain) (kondisi) (berat) "
                     "(merek) (seri) (fret) (senar)" + RESET)
        return

    # berat disimpan sebagai string supaya satuan "kg" ikut tersimpan
    weight = "{:.1f} kg".format(weight_number)

    temp = Guitar(id_, price, stock, playing_method, condition, weight,
                  brand, series, fret_size, string_type)
    v.append(temp)
    print(GREEN + "Gitar \"" + brand + " " + series + "\" berhasil ditambahkan dengan id "
          + str(id_) + "." + RESET)


# prosedur untuk menampilkan seluruh gitar yang ada di dalam list
def show(v):
    headers = ["ID", "Harga", "Stok", "CaraMain", "Kondisi",
               "Berat", "Merek", "Seri", "Fret", "Senar"]

    rows = [guitar_to_row(item) for item in v]

    print("Daftar Gitar di Toko:")
    print_dynamic_table(headers, rows)
    print("Total gitar: " + str(len(v)))


def main():
    print(BLUE + "Selamat datang di Toko Gitar kami!" + RESET)
    print("(Ketik 'panduan' untuk menampilkan daftar perintah.)")

    v = []

    # 1. data gitar hardcode (5 gitar)
    v.append(Guitar(1, 1500000, 24, "dipetik", "baru", "2.5 kg", "Yamaha", "Pacifica112", 24, "nikel"))
    v.append(Guitar(2, 1200000, 2, "dipetik", "bekas", "2.7 kg", "Fender", "Player Stratocaster", 22, "baja"))
    v.append(Guitar(3, 1200000, 9, "dipetik", "likenew", "5.5 kg", "Jackson", "JS22 Dinky", 24, "nikel"))
    v.append(Guitar(4, 2100000, 5, "dipetik", "ori", "3.1 kg", "Schecter", "Omen Elite-6", 22, "baja"))
    v.append(Guitar(5, 800000, 12, "dipetik", "premium", "1.9 kg", "Yamaha", "C40 Classic", 19, "nilon"))

    print(BLUE + "Apa yang ingin anda lakukan hari ini?" + RESET)

    masih = True

    while masih:
        print("|| ", end="")
        try:
            command_line = input()
        except EOFError:
            break

        tokens = command_line.split()
        if not tokens:
            continue

        cmd = tokens[0].lower()

        # kalo done langsung berhenti (exit dari program)
        if cmd == "done":
            masih = False
        else:
            kosong = len(v) == 0
            if cmd == "add":
                add(v, tokens[1:])
            elif cmd == "show":
                if kosong:
                    zeroo()
                else:
                    show(v)
            elif cmd == "panduan":
                panduan()
            else:
                print(RED + "Perintah tidak dikenali. Ketik 'panduan' untuk melihat daftar perintah." + RESET)
            print(BLUE + "Apakah ada yang ingin anda lakukan lagi?" + RESET)

    print(GREEN + "Terimakasih dan silahkan datang kembali!" + RESET)


if __name__ == "__main__":
    main()