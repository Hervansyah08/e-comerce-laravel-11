 <img src="{{ asset('storage/' . $store->image) }}" class="{{ $class }}" alt="RD Iphone House" />


 public $store;
 public function __construct()
 {
 $this->store = Store::pluck('image')->first();
 }
