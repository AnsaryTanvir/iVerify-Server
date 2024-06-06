from Crypto.PublicKey import RSA

# Generate key pair
key = RSA.generate(2048)

# Export private key
private_key = key.export_key()
with open("private_key.pem", "wb") as private_file:
    private_file.write(private_key)

# Export public key
public_key = key.publickey().export_key()
with open("public_key.pem", "wb") as public_file:
    public_file.write(public_key)

print("Private and public keys have been saved in the current directory.")
