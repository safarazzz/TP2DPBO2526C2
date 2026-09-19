from MusicInstrument import MusicInstrument

class Guitar(MusicInstrument):
    def __init__(self, id=0, price=0.0, stock=0,
                 playing_method="", condition="", weight="",
                 brand="", series="", fret_size=0, string_type=""):
        super().__init__(id, price, stock, playing_method, condition, weight)
        self.brand = brand
        self.series = series
        self.fret_size = fret_size
        self.string_type = string_type

    # getter and setter brand
    def set_brand(self, brand):
        self.brand = brand

    def get_brand(self):
        return self.brand

    # getter and setter series
    def set_series(self, series):
        self.series = series

    def get_series(self):
        return self.series

    # getter and setter fretSize
    def set_fret_size(self, fret_size):
        self.fret_size = fret_size

    def get_fret_size(self):
        return self.fret_size

    # getter and setter stringType
    def set_string_type(self, string_type):
        self.string_type = string_type

    def get_string_type(self):
        return self.string_type