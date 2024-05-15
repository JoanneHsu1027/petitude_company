function updatecitys() {
    var countySelect = document.getElementById("fk_county_id");
    var citySelect = document.getElementById("fk_city_id");
    var county = countySelect.value;
    citySelect.innerHTML = ""; // 清除鄉鎮區選項

    // 根據選擇的縣市，添加相應的鄉鎮區選項
    switch (county) {
        case "1":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 1; j <= 12; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "2":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 13; j <= 19; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "3":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 20; j <= 48; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "4":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 49; j <= 61; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "5":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 62; j <= 64; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "6":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 65; j <= 77; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "7":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 78; j <= 90; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "8":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 91; j <= 108; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "9":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 109; j <= 137; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "10":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 138; j <= 163; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "11":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 164; j <= 176; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "12":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 177; j <= 178; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "13":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 179; j <= 196; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "14":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 197; j <= 216; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "15":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 217; j <= 253; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "16":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 254; j <= 291; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "17":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 292; j <= 293; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "18":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 294; j <= 299; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "19":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 300; j <= 332; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "20":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 333; j <= 348; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "21":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 349; j <= 361; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "22":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 362; j <= 367; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "23":
            addOption(citySelect, "請選擇鄉鎮地區", 0);
            for (var j = 368; j <= 371; j++) {
                addOption(citySelect, cities[j], j);
            }
            break;
        case "0":
            addOption(citySelect, "請先選擇縣市", 0);
            break;
    }
}

function addOption(selectElement, optionText, optionValue) {
    var option = document.createElement("option");
    option.text = optionText;
    option.value = optionValue;
    selectElement.add(option);
}