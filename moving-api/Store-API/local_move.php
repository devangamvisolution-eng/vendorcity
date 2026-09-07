<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://vendorscity.com/beta/api/store-moving-service',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "service_id": 30,
  "subservice_id": 98,
  "form_type": "Local Move",
  "fields": [
    {
      "field_id": 17,
      "field_type": "radio",
      "value": [52]
    },
    {
      "field_id": 45,
      "field_type": "text",
      "value": "Meghaninagar"
    },
    {
      "field_id": 18,
      "field_type": "radio",
      "value": [68]
    },
    {
      "field_id": 46,
      "field_type": "text",
      "value": "vastral"
    },
    {
      "field_id": 20,
      "field_type": "radio",
      "value": [57],
      "more_options": [25]
    },
    {
      "field_id": 21,
      "field_type": "date",
      "value": "2026-08-29"
    },
    {
      "field_id": 22,
      "field_type": "text",
      "value": "sdsdwd"
    },
    {
      "field_id": 57,
      "field_type": "text",
      "value": 380
    }
  ]
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3ZlbmRvcnNjaXR5LmNvbS9iZXRhL2FwaS92MS9hdXRoL3ZlcmlmeS1vdHAiLCJpYXQiOjE3ODc2NDMxOTUsImV4cCI6MTc5MDIzNTE5NSwibmJmIjoxNzg3NjQzMTk1LCJqdGkiOiI0aVR6cko1WWdMYWFZM2ljIiwic3ViIjoiMSIsInBydiI6IjhjNWRhY2IzOWNhNjE3NzVmODBlZjQyZWM2MGRjMTM0ZjZjMDQ2ZGUifQ.CXrmN1m_KqpBs1q_bpktrR3O1jowlF79Q2GfXAreZrU',
    'Accept: application/json',
    'Content-Type: application/json',
    'Cookie: XSRF-TOKEN=eyJpdiI6Ik5Qb21GRStTQ09zVWo1NmVTNy9CQnc9PSIsInZhbHVlIjoiM1hWK1FhRS9wZ1prVmFUd3JIWWtqRCthQWRnTnY0TGVBT2ZITVhxenkzVGhjdUpqbXB3aHdaSTRCRFY1c1FVVlhMcXpEZmpWR2pyRlU2ZmhHTWM2d3dWc2JXVGVkVExJcU8xUVpQcWJmMjVoRllJSzdEZmw1TnBoUHFzVkM3R0YiLCJtYWMiOiIwMGI1MmQ1ZDVmYWZkOWRhMDBlMTllYzA4ZjAyZjYxYWRkYzIwZGE3OTdhMWExZTYxODQxOWZmM2I2ODNiZWQwIiwidGFnIjoiIn0%3D; vendorscity_session=eyJpdiI6IkJTSVpVek9leno2V0VXOUsrQktuMEE9PSIsInZhbHVlIjoidUNSWVpIaE1KbkZxRWhvUHNZNDdRVXEvNzFlcko4MzErb2wwcGxhMUZ6aC9XbEZlcTdvNGRIYkRIcDBXTjNvdmJZR0lHaUNzRkliSm9hMkROcldqSUVObzR1WHArL3NnWnc0NTdsVzFqOStDcTI5Tk91N3o5UkxvcjF4WHZWZ1UiLCJtYWMiOiI2YzZkOTFiNTM2ZDY5NDczZGRiMmVhZjM2N2Q2MzlhMWY0MzViM2I4YTNlYzA2NzYwZWE1NzliMDliZmMwMWMzIiwidGFnIjoiIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
