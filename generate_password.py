import json
import secrets
import string

a = 1

random = secrets.SystemRandom()
FILE_NAME = 'data.json'
password_content = str()
password = str()

with open(FILE_NAME, 'r') as file:
    data = json.load(file)
    if data['symbols']:
        password_content = string.punctuation
    if data['numbers']:
        password_content += string.digits
    if data['uppercase']:
        password_content += string.ascii_uppercase
    if data['lowercase']:
        password_content += string.ascii_lowercase

    length = int(data['length'])

for i in range(1, length + 1):
    n = random.randint(0, len(password_content)) - 1
    password += password_content[n]

print(password)
