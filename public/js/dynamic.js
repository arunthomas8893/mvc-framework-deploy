//Category Items
var category = {
    electronics: [
        "Mobiles",
        "Tablets",
        "Laptops",
        "HomeAppliances",
        "Camera",
        "Photo & Video",
        "Televisions",
        "Headphones",
        "Gaming Hub",
    ],
    fashion: [
        "Women's Fashion",
        "Men's Fashion",
        "Girls' Fashion",
        "Boys' Fashion",
        "Watches",
        "Jewellers",
        "Women's Handbags",
        "Men's Eyewear",
    ],
    homeandkitchen: [
        "Kitchen & Dining",
        "Bedding",
        "Bath",
        "Home Decor",
        "Home Appliances",
        "Tools & Home Improvement",
        "Patio, Lawn & Garden",
        "Pet supplies",
    ],
    beauty: [
        "Women's Fragrance",
        "Men's Fragrance",
        "Make-up",
        "Haircare",
        "Skincare",
        "Personal Care",
        "Tools & Accessories",
        "Men's Grooming",
    ],
    kbt: [
        "Girls' Fashion",
        "Boys' Fashion",
        "Baby Clothing & Shoes",
        "Feeding",
        "Bathing & Skincare",
        "Diapering",
        "Baby & Toddler Toys",
        "Toys & Games",
    ],
    topbrands: [
        "Mothercare",
        "Apple",
        "Tefal",
        "l'Oreal paris",
        "Skechers",
        "Villeroy & Boch",
        "Nike",
        "Samsung",
    ],
};
//SubCategory Items

const subcategory = {
    Mobiles: ["Samsung", "OnePlus", "Apple", "Vivo", "Oppo", "Lenovo", "Motorola", "LG",],
    Tablets: ["SamsungTablets", "AppleTablets", "LenovoTablets", "LGTablets",],
    Laptops: ["HP", "Dell", "Asus", "Lenovo", "Acer", "Apple", "Samsung Laptops", "Huawei",],
    HomeAppliances: ["Whirlpool", "Amana", "LG", "Frigidaire", "Maytag", "Miele", "Samsung Home Appliances", "Gaggenau",],
    Camera: ["Canon", "Nikon", "Sony", "Fujifilm", "Olympus", "Panasonic", "Pentax",],
};
//Brand Items

var brands = {
    Samsung: ["Samsung Galaxy Z Fold2 5G", "Samsung Galaxy Note 20", "Samsung Galaxy Note 20 Ultra", "Samsung Galaxy Tab S7", "Samsung Galaxy Tab S7+", "Samsung Galaxy A51 5G UW", "Samsung Galaxy M31s", "Samsung Galaxy M51", "Samsung Galaxy Z Flip 5G", "Samsung Galaxy A01 Core", "Samsung Galaxy M01s", "Samsung Galaxy A71 5G UW", "Samsung Galaxy M01", "Samsung Galaxy A21s", "Samsung Galaxy J2 Core (2020)",],
    OnePlus: ["OnePlus One", "OnePlus 2", "OnePlus X", "OnePlus 3", "OnePlus 3T", "OnePlus 5", "OnePlus 5T", "OnePlus 6",],
    Apple: ["Iphone SE", "Iphone 6", "Iphone 7", "Iphone 8", "Iphone 9", "Iphone 10", "Iphone 11", "Iphone 12",],
};

// getting the main and sub menus

var main = document.getElementById("main_menu");
var sub = document.getElementById("sub_menu");
var sub2 = document.getElementById("sub_menu2");
var sub3 = document.getElementById("sub_menu3");

// Trigger the Event when main menu change occurs

main.addEventListener("change", function () {
    selectOptionDynamic(this, "sub_menu", category);
});

sub.addEventListener("change", function () {
    selectOptionDynamic(this, "sub_menu2", subcategory);
});

sub2.addEventListener("change", function () {
    selectOptionDynamic(this, "sub_menu3", brands);
});

function selectOptionDynamic(selectedoption, submenu, submenuValueObject) {
    var sub = document.getElementById(submenu);
    // getting a selected option

    var selected_option = submenuValueObject[selectedoption.value];

    // removing the sub menu options using while loop

    while (sub.options.length > 0) {
        sub.options.remove(0);
    }

    //conver the selected object into array and create a options for each array elements
    //using Option constructor  it will create html element with the given value and innerText

    Array.from(selected_option).forEach(function (el) {
        let option = new Option(el, el);

        //append the child option in sub menu

        sub.appendChild(option);
    });
}