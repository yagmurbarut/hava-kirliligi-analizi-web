<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hava Kirliliği Analizi</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js Kütüphanesini dahil et -->
</head>
<body>
 <!-- Navbar -->
 <div class="navbar">
        <div>Hava Kirliliği Analizi</div>
        <div>
            <a href="index.php">Ana Sayfa</a>
            <a href="about.php">Hakkımızda</a>
            <a href="contact.php">İletişim</a>
        </div>
    </div>

   
    
    <!-- Bölge - Ülke - Şehir Seçimi -->
    <div class="selection-container">
        <h2>Hangi bölgeye bakmak istiyorsunuz?</h2>
        
        <!-- Bölge Seçimi -->
        <select id="regionSelect" onchange="loadCountries()">
            <option value="">Bölge Seçin</option>
            <option value="avrupa">Avrupa</option>
            <option value="asya">Asya</option>
            <option value="amerika">Amerika</option>
            <option value="afrika">Afrika</option>
            <option value="okyanusya">Okyanusya</option>
        </select>

        <!-- Ülke Seçimi -->
        <select id="countrySelect" class="hidden" onchange="loadCities()">
            <option value="">Önce Bölge Seçin</option>
        </select>

        <!-- Şehir Seçimi -->
        <select id="citySelect" class="hidden" onchange="showData()">
            <option value="">Önce Ülke Seçin</option>
        </select>

        <!-- Seçilen Şehir Bilgisi -->
        <h2 id="cityInfo" class="hidden"></h2>
    </div>

    <!-- Hava Kirliliği Verileri Grafik -->
    <div>
        <h2 id="chartTitle" class="hidden">Hava Kirliliği Verileri</h2>
        <canvas id="myChart" class="hidden"></canvas> <!-- Grafik için Canvas -->
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 Hava Kirliliği Projesi
    </div>

    <script>
        // Bölgelerin ülkeleri
        const countries = {
            avrupa: ["Türkiye", "Almanya", "Fransa", "İtalya", "İspanya"],
            asya: ["Çin", "Japonya", "Hindistan", "Güney Kore", "Endonezya"],
            amerika: ["ABD", "Kanada", "Brezilya", "Arjantin", "Meksika"],
            afrika: ["Mısır", "Güney Afrika", "Kenya", "Fas", "Nijerya"],
            okyanusya: ["Avustralya", "Yeni Zelanda", "Fiji"]
        };

        // Ülkelerin şehirleri
        const cities = {
            "Türkiye": ["İstanbul", "Ankara", "İzmir", "Bursa", "Antalya"],
            "Almanya": ["Berlin", "Münih", "Hamburg", "Frankfurt", "Köln"],
            "Fransa": ["Paris", "Lyon", "Marsilya", "Nice", "Bordeaux"],
            "İtalya": ["Roma", "Milano", "Napoli", "Floransa", "Torino"],
            "İspanya": ["Madrid", "Barselona", "Valensiya", "Sevilla", "Bilbao"],
            "İngiltere": ["Londra", "Manchester", "Birmingham", "Liverpool", "Edinburgh"],
            "Hollanda": ["Amsterdam", "Rotterdam", "Lahey", "Utrecht", "Eindhoven"],
            "Belçika": ["Brüksel", "Antwerp", "Gent", "Liege", "Brugge"],
            "İsveç": ["Stockholm", "Göteborg", "Malmö", "Uppsala", "Västerås"],
            "Norveç": ["Oslo", "Bergen", "Trondheim", "Stavanger", "Drammen"],
            "ABD": ["New York", "Los Angeles", "Chicago", "Houston", "San Francisco"],
            "Kanada": ["Toronto", "Vancouver", "Montreal", "Ottawa", "Calgary"],
            "Brezilya": ["Rio de Janeiro", "Sao Paulo", "Brasilia", "Salvador", "Curitiba"],
            "Arjantin": ["Buenos Aires", "Cordoba", "Rosario", "Mendoza", "La Plata"],
            "Meksika": ["Mexico City", "Guadalajara", "Monterrey", "Puebla", "Tijuana"],
            "Çin": ["Pekin", "Şangay", "Guangzhou", "Shenzhen", "Wuhan"],
            "Japonya": ["Tokyo", "Osaka", "Kyoto", "Yokohama", "Fukuoka"],
            "Hindistan": ["Yeni Delhi", "Mumbai", "Kalküta", "Bangalore", "Chennai"],
            "Güney Kore": ["Seul", "Busan", "Incheon", "Daegu", "Daejeon"],
            "Endonezya": ["Cakarta", "Surabaya", "Bandung", "Medan", "Semarang"],
            "Mısır": ["Kahire", "İskenderiye", "Gize", "Luxor", "Asvan"],
            "Güney Afrika": ["Cape Town", "Johannesburg", "Pretoria", "Durban", "Bloemfontein"],
            "Kenya": ["Nairobi", "Mombasa", "Kisumu", "Nakuru", "Eldoret"],
            "Fas": ["Rabat", "Kazablanka", "Marakeş", "Fes", "Tanca"],
            "Nijerya": ["Lagos", "Abuja", "Ibadan", "Kano", "Port Harcourt"],
            "Avustralya": ["Sidney", "Melbourne", "Brisbane", "Perth", "Adelaide"],
            "Yeni Zelanda": ["Auckland", "Wellington", "Christchurch", "Hamilton", "Dunedin"]
        };

        // Ülke listesini doldur
        function loadCountries() {
            const region = document.getElementById("regionSelect").value;
            const countrySelect = document.getElementById("countrySelect");
            countrySelect.innerHTML = '<option value="">Ülke Seçin</option>';

            if (region && countries[region]) {
                countries[region].forEach(country => {
                    const option = document.createElement("option");
                    option.value = country;
                    option.textContent = country;
                    countrySelect.appendChild(option);
                });

                countrySelect.classList.remove("hidden");
                setTimeout(() => {
                    countrySelect.style.opacity = 1;
                }, 100);
            } else {
                countrySelect.classList.add("hidden");
                document.getElementById("citySelect").classList.add("hidden");
                document.getElementById("cityInfo").classList.add("hidden");
                document.getElementById("chartTitle").classList.add("hidden");
                document.getElementById("myChart").classList.add("hidden");
            }
        }

        // Şehir listesini doldur
        function loadCities() {
            const country = document.getElementById("countrySelect").value;
            const citySelect = document.getElementById("citySelect");
            citySelect.innerHTML = '<option value="">Şehir Seçin</option>';

            if (country && cities[country]) {
                cities[country].forEach(city => {
                    const option = document.createElement("option");
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });

                citySelect.classList.remove("hidden");
                setTimeout(() => {
                    citySelect.style.opacity = 1;
                }, 100);
            } else {
                citySelect.classList.add("hidden");
                document.getElementById("cityInfo").classList.add("hidden");
                document.getElementById("chartTitle").classList.add("hidden");
                document.getElementById("myChart").classList.add("hidden");
            }
        }

        // Seçilen şehir bilgisini göster
        function showData() {
            const city = document.getElementById("citySelect").value;
            const cityInfo = document.getElementById("cityInfo");
            const chartTitle = document.getElementById("chartTitle");
            const myChartCanvas = document.getElementById("myChart");

            if (city) {
                cityInfo.textContent = `${city} için hava kirliliği verileri yükleniyor...`;
                cityInfo.classList.remove("hidden");

                // Burada AJAX veya API ile hava verilerini çekeceğiz
                setTimeout(() => {
                    cityInfo.textContent = `${city} için hava kirliliği verileri: PM2.5 - 35µg/m³, CO - 0.8ppm`;

                    // Grafik Verileri
                    const pm25 = 35; // API'den alınacak veriler
                    const co = 0.8;  // API'den alınacak veriler
                    const no2 = 25;  // API'den alınacak veriler

                    chartTitle.classList.remove("hidden");
                    myChartCanvas.classList.remove("hidden");

                    // Chart.js grafiğini oluştur
                    const ctx = myChartCanvas.getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['PM2.5', 'CO', 'NO2'],
                            datasets: [{
                                label: 'Hava Kirliliği Verileri',
                                data: [pm25, co, no2], // Bu veriler API'den alınacak
                                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }, 2000);
            } else {
                cityInfo.classList.add("hidden");
                chartTitle.classList.add("hidden");
                myChartCanvas.classList.add("hidden");
            }
        }
    </script>
</body>
</html>
