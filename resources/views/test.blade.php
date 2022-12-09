1 - Write a php program which will
If customer upload a file abc.jpg
A) Create directory with pub/media
Function
b) Create a new directory in pub/media directory with the first letter of file in above case it will be a
c) Create a new directory second character of upload file in pub/media/{first letter of upload file}
d) Upload a file to pub/media/{first letter of upload file}/{second letter of upload file} directory
Notes:
1) If file with the same name already exist then attach current date and time with the file for example
abc-YEARMONTHDAY-TIME.jpg then upload it
2) If file characters are less than one for example a.jpg then it will be uploaded at pub/media/a/_
