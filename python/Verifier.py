from Crypto.PublicKey import RSA
from Crypto.Cipher import PKCS1_OAEP

# Load private key from file
with open("private_key.pem", "rb") as private_file:
    private_key_data = private_file.read()

private_key = RSA.import_key(private_key_data)

# Load encrypted data from file or use the previously printed data
encrypted_base64 = input("Enter the encrypted data: ")

# Convert base64-encoded string to bytes
ciphertext = bytes.fromhex(encrypted_base64)

# Decrypt data
decrypt_cipher = PKCS1_OAEP.new(private_key)
decrypted_data = decrypt_cipher.decrypt(ciphertext)

print("\nDecrypted Data:")
print(decrypted_data.decode())
