# Kan Ver Hayat Ver API
#### API Kimlik Doğrulama
_Kan Ver Hayat Ver API_ hizmetini kullanabilmek için `api_key_secret` header bilgisinin her API çağrısında gönderilmesi gerekir.
##### Örnek:
```curl
curl --location --request GET 'https://api.kanverhayatver.org/check_device/1' \
--header 'api_key_secret: 1111'
```
#### Kullanıcı Kayıt Doğrulama
Kullanıcı uygulamayı indirdiği zaman `/check_device/{device_id}` parametresine ``device_id``
gönderilerek kullanıcıya ilişkin detaylı bilgiler json formatında cevap olarak döndürülür.
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