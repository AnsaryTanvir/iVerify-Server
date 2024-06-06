from Crypto.PublicKey import RSA
from Crypto.Cipher import PKCS1_OAEP
import qrcode

class EncryptionHandler:
    
    def __init__(self, public_key_path):
        self.public_key_path = public_key_path
        self.public_key = self.load_public_key()

    def load_public_key(self):
        try:
            with open(self.public_key_path, "rb") as public_file:
                public_key_data = public_file.read()

            return RSA.import_key(public_key_data)
        except Exception as e:
            raise RuntimeError(f"Error loading public key: {str(e)}")

    def encrypt_data(self, data):
        try:
            cipher = PKCS1_OAEP.new(self.public_key)
            ciphertext = cipher.encrypt(data)
            return ciphertext.hex()
        except Exception as e:
            raise RuntimeError(f"Error encrypting data: {str(e)}")

def create_qr_code(data):
    try:
        qr = qrcode.QRCode(
            version=1,
            error_correction=qrcode.constants.ERROR_CORRECT_M,
            box_size=10,
            border=4,
        )
        qr.add_data(data)
        qr.make(fit=True)
        return qr.make_image(fill_color="black", back_color="white")
    except Exception as e:
        raise RuntimeError(f"Error creating QR code: {str(e)}")

def main():
    
    
    data_to_encrypt = b"8533e3d2-97a1-4435-9f0a-f8c6a64e0c61"

    try:
        
        public_key_path = "public_key.pem"
        encryption_handler = EncryptionHandler(public_key_path)

        # Encrypt data
        encrypted_base64 = encryption_handler.encrypt_data(data_to_encrypt)

        # Print the encrypted data
        print("Encrypted Data:")
        print(encrypted_base64)

        # Create a QR code
        img = create_qr_code(encrypted_base64)

        # Save the image
        img.save("encrypted_qr_code.png")
        print("Encrypted data has been printed and converted to a QR code, and saved.")

    except RuntimeError as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    main()
