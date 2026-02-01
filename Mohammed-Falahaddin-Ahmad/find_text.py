
file_path = r'c:\The Final Project Folder\Edited-FinalProject\public\user\assets\css\main.css'
search_terms = ['top-ratting-box-items', 'shop-btn']

try:
    with open(file_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()
        for i, line in enumerate(lines):
            for term in search_terms:
                if term in line:
                    print(f"Found '{term}' at line {i+1}: {line.strip()}")
except Exception as e:
    print(f"Error: {e}")
