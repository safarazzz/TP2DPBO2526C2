import java.util.*;

public class Main {
    // deklarasi warna ANSI
    static final String RED   = "\u001B[31m";
    static final String BLUE  = "\u001B[34m";
    static final String GREEN = "\u001B[32m";
    static final String RESET = "\u001B[0m";

    // helper untuk mencetak garis pembatas tabel sesuai lebar tiap kolom
    static void printLine(List<Integer> widths) {
        StringBuilder sb = new StringBuilder("+");
        for (int w : widths) {
            sb.append("-".repeat(w + 2)).append("+");
        }
        System.out.println(sb);
    }

    // helper untuk mencetak satu baris tabel sesuai lebar tiap kolom
    static void printRow(List<String> cells, List<Integer> widths) {
        StringBuilder sb = new StringBuilder("|");
        for (int i = 0; i < cells.size(); i++) {
            sb.append(" ")
              .append(String.format("%-" + widths.get(i) + "s", cells.get(i)))
              .append(" |");
        }
        System.out.println(sb);
    }

    // mengubah satu objek Guitar menjadi satu baris data (String) untuk
    // tabel, menggunakan getter saja (tidak menyentuh atribut private)
    static List<String> guitarToRow(Guitar item) {
        List<String> row = new ArrayList<>();
        row.add(String.valueOf(item.getId()));
        row.add(String.valueOf((long) item.getPrice()));
        row.add(String.valueOf(item.getStock()));
        row.add(item.getPlayingMethod());
        row.add(item.getCondition());
        row.add(item.getWeight());
        row.add(item.getBrand());
        row.add(item.getSeries());
        row.add(String.valueOf(item.getFretSize()));
        row.add(item.getStringType());
        return row;
    }

    // mencetak tabel DINAMIS: lebar tiap kolom dihitung otomatis dari
    // panjang data terpanjang di kolom tersebut (termasuk headernya),
    // jadi tabel selalu rapi berapapun panjang data yang dimasukkan.
    static void printDynamicTable(List<String> headers, List<List<String>> rows) {
        int jumlahKolom = headers.size();
        List<Integer> width = new ArrayList<>();
        for (String h : headers) width.add(h.length());

        for (List<String> row : rows) {
            for (int c = 0; c < jumlahKolom; c++) {
                if (row.get(c).length() > width.get(c)) {
                    width.set(c, row.get(c).length());
                }
            }
        }

        printLine(width);
        printRow(headers, width);
        printLine(width);
        for (List<String> row : rows) {
            printRow(row, width);
        }
        printLine(width);
    }

    // prosedur untuk menampilkan pesan kesalahan ketika daftar gitar masih kosong
    static void zeroo() {
        System.out.println(RED
                + "Daftar gitar anda masih kosong!\n"
                + "Tambahkan setidaknya satu gitar untuk menjalankan perintah ini."
                + RESET);
    }

    // prosedur panduan untuk menampilkan daftar perintah yang tersedia
    static void panduan() {
        List<String> headers = Arrays.asList("Perintah", "Format Penggunaan", "Keterangan");
        List<List<String>> rows = new ArrayList<>();
        rows.add(Arrays.asList("add", "add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar)", "Menambahkan satu gitar baru ke daftar."));
        rows.add(Arrays.asList("show", "show", "Menampilkan seluruh gitar dalam tabel dinamis."));
        rows.add(Arrays.asList("panduan", "panduan", "Menampilkan panduan ini."));
        rows.add(Arrays.asList("done", "done", "Mengakhiri sesi program."));

        System.out.println("Panduan penggunaan program Toko Gitar");
        printDynamicTable(headers, rows);
        System.out.println();
    }

    // prosedur untuk menambahkan gitar baru berdasarkan input satu baris
    // perintah. Sudah dilengkapi error handling: kalau jumlah token salah
    // atau ada angka yang tidak valid, program tidak crash tapi memberi
    // pesan error yang jelas.
    static void add(List<Guitar> v, String[] tokens) {
        // tokens[0] = "add", jadi data sebenarnya mulai dari index 1
        // sama seperti versi C++: kalau formatnya salah (jumlah token
        // tidak pas ATAU ada nilai yang gagal dibaca sebagai angka),
        // tampilkan pesan error yang sama persis.
        try {
            if (tokens.length != 11) {
                throw new IllegalArgumentException();
            }
            int id = Integer.parseInt(tokens[1]);
            double price = Double.parseDouble(tokens[2]);
            int stock = Integer.parseInt(tokens[3]);
            String playingMethod = tokens[4];
            String condition = tokens[5];
            double weightNumber = Double.parseDouble(tokens[6]);
            String brand = tokens[7];
            String series = tokens[8];
            int fretSize = Integer.parseInt(tokens[9]);
            String stringType = tokens[10];

            // berat disimpan sebagai String supaya satuan "kg" ikut tersimpan
            String weight = String.format(Locale.US, "%.1f kg", weightNumber);

            Guitar temp = new Guitar(id, price, stock, playingMethod, condition, weight,
                                      brand, series, fretSize, stringType);
            v.add(temp);
            System.out.println(GREEN + "Gitar \"" + brand + " " + series + "\" berhasil ditambahkan dengan id " + id + "." + RESET);
        } catch (IllegalArgumentException e) {
            System.out.println(RED + "Format salah. Gunakan: add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar)" + RESET);
        }
    }

    // prosedur untuk menampilkan seluruh gitar yang ada di dalam list
    static void show(List<Guitar> v) {
        List<String> headers = Arrays.asList(
                "ID", "Harga", "Stok", "CaraMain", "Kondisi",
                "Berat", "Merek", "Seri", "Fret", "Senar"
        );

        List<List<String>> rows = new ArrayList<>();
        for (Guitar item : v) {
            rows.add(guitarToRow(item));
        }

        System.out.println("Daftar Gitar di Toko:");
        printDynamicTable(headers, rows);
        System.out.println("Total gitar: " + v.size());
    }

    public static void main(String[] args) {
        System.out.println(BLUE + "Selamat datang di Toko Gitar kami!" + RESET);
        System.out.println("(Ketik 'panduan' untuk menampilkan daftar perintah.)");

        List<Guitar> v = new ArrayList<>();

        // 1. data gitar hardcode (5 gitar)
        v.add(new Guitar(1, 1500000, 24, "dipetik", "baru",    "2.5 kg", "Yamaha",   "Pacifica112",         24, "nikel"));
        v.add(new Guitar(2, 1200000, 2,  "dipetik", "bekas",   "2.7 kg", "Fender",   "Player Stratocaster", 22, "baja"));
        v.add(new Guitar(3, 1200000, 9,  "dipetik", "likenew", "5.5 kg", "Jackson",  "JS22 Dinky",          24, "nikel"));
        v.add(new Guitar(4, 2100000, 5,  "dipetik", "ori",     "3.1 kg", "Schecter", "Omen Elite-6",        22, "baja"));
        v.add(new Guitar(5, 800000,  12, "dipetik", "premium", "1.9 kg", "Yamaha",   "C40 Classic",         19, "nilon"));

        System.out.println(BLUE + "Apa yang ingin anda lakukan hari ini?" + RESET);

        Scanner scanner = new Scanner(System.in);
        boolean masih = true;

        while (masih) {
            System.out.print("|| ");
            if (!scanner.hasNextLine()) break;
            String commandLine = scanner.nextLine().trim();
            if (commandLine.isEmpty()) continue;

            String[] tokens = commandLine.split("\\s+");
            String input = tokens[0].toLowerCase();

            // kalo done langsung berhenti (exit dari program)
            if (input.equals("done")) {
                masih = false;
            } else {
                boolean kosong = v.isEmpty();
                switch (input) {
                    case "add":
                        add(v, tokens);
                        break;
                    case "show":
                        if (kosong) zeroo();
                        else show(v);
                        break;
                    case "panduan":
                        panduan();
                        break;
                    default:
                        System.out.println(RED + "Perintah tidak dikenali. Ketik 'panduan' untuk melihat daftar perintah." + RESET);
                }
                System.out.println(BLUE + "Apakah ada yang ingin anda lakukan lagi?" + RESET);
            }
        }

        System.out.println(GREEN + "Terimakasih dan silahkan datang kembali!" + RESET);
        scanner.close();
    }
}