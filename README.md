# Kan Ver Hayat Ver API v1.0
#### API Kimlik Doğrulama
Kan Ver Hayat Ver API hizmetini kullanabilmek için `Api-Secret-Key` header bilgisinin her API çağrısında gönderilmesi gerekir.
##### Örnek:
```curl
curl --location --request GET 'https://api.kanverhayatver.org/check_device/1' \
--header 'Api-Secret-Key: 1111'
```
#### GET - Kullanıcı Kayıt Doğrulama
Kullanıcı uygulamayı indirdiğinde `/check_device/{device_id}` bağlantısına ``device_id``
gönderilerek eğer daha önce kayıt olmuşsa kullanıcıya ilişkin detaylı bilgiler json formatında cevap olarak döndürülür.
##### Örnek:
```json
{
    "status": 1,
    "data": [
        {
            "id": "1",
            "user_id": "1",
            "device_id": "1",
            "province": "1",
            "district": "1",
            "neighborhood": "1",
            "latitude": "1",
            "longitude": "1"
        }
    ]
}
```
### POST - Yeni Kullanıcı Kayıt Oluşturma
Yeni kullanıcı kaydı oluşturmak için `/register/{device_id}` bağlantısına kullanıcının doldurduğu bilgileri göndermeniz gerekir.

##### Kan Grupları:
| blood_type | Kan Grubu |  blood_type | Kan Grubu |
| :---:  | ------------- | :---: | ------------- |
| **1**  | A Rh+  |  **2**  | A Rh- |
| **3**  | B Rh+  | **4**  | B Rh- |
| **5**  | AB Rh+  | **6**  | AB Rh- |
| **7**  | O Rh+  | **8**  | O Rh-  |
##### Örnek:
```curl
curl --location --request POST 'https://api.kanverhayatver.org/register/3' \
--header 'Api-Secret-Key: 1111' \
--form 'identity_number=12427827548' \
--form 'name=sercan' \
--form 'surname=arga' \
--form 'blood_type=2' \
--form 'phone_number=5071773757' \
--form 'device_agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36' \
```
##### Çıktı:
```json
{
    "status": 1,
    "msg": "User created"
}
```
##### Kullanıcı Zaten Kayıtlıysa:
```json
{
    "status": 0,
    "msg": "User already exists"
}
```
##### Eksik Parametre:
```json
{
    "errorInfo": [
        "23000",
        1048,
        "Column 'identity_number' cannot be null"
    ]
}
```
### POST - Kullanıcı Detayı
Yeni kullanıcı kaydı oluşturulduktan sonra kullanıcının konum bilgileri `/register_details/{device_id}` bağlantısına gönderilmelidir.
```curl
curl --location --request POST 'https://api.kanverhayatver.org/register_details/15' \
--header 'Api-Secret-Key: 1111' \
--form 'province=İstanbul' \
--form 'district=Şişli' \
--form 'neighborhood=Yayla Sok.' \
--form 'latitude=41.0550272' \
--form 'longitude=28.9538047999999997'
```
##### Çıktı:
```json
{
    "status": 1,
    "msg": "Update sucessful"
}
```
##### Kullanıcı Yoksa:
```json
{
    "status": 0,
    "msg": "User not exists"
}
```
### POST - Bağış Oluşturma
Kullanıcı bağış yaptığında bunu kaydetmek için `/donate_register/{user_id}` bağlantısı kullanılmalıdır.
```curl
curl --location --request POST 'https://api.kanverhayatver.org/donate_register/3' \
--header 'Api-Secret-Key: 1111' \
--form 'donation_value=20' \
--form 'invoice_number=1111'
```
##### Çıktı:
```json
{
    "status": 1,
    "msg": "Donation created"
}
```
##### Kullanıcı Yoksa:
```json
{
    "status": 0,
    "msg": "User not exists"
}
```
#### GET - Son 50 Bağışı Listeleme
Son 50 bağışın listelenmesi için `/last_donations` bağlantısına istek göndermelisiniz.
```curl
curl --location --request GET 'http://api.kanverhayatver.org/last_donations' \
--header 'Api-Secret-Key: 1111'
```
##### Örnek:
```json
{
    "status": 1,
    "data": [
        {
            "user_id": "1",
            "donation_value": "120.00",
            "date": "2020-09-05 18:55:32"
        },
        {
            "user_id": "3",
            "donation_value": "80.00",
            "date": "2020-09-05 18:55:21"
        },
        {
            "user_id": "3",
            "donation_value": "40.00",
            "date": "2020-09-05 18:55:16"
        },
        {
            "user_id": "2",
            "donation_value": "40.00",
            "date": "2020-09-05 18:55:11"
        },
        {
            "user_id": "1",
            "donation_value": "20.00",
            "date": "2020-09-05 13:53:34"
        }
    ]
}
```
