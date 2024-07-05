import sys
import mysql.connector
import json

def fetch_responses(username):
    # Database connection settings
    db_config = {
        'host': 'localhost',
        'user': 'root',
        'password': '',
        'database': 'skinproject'
    }

    # Establish database connection
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Fetch form responses from the database based on username
        query = "SELECT * FROM responses WHERE username = %s"
        cursor.execute(query, (username,))
        row = cursor.fetchone()

        if row:
            responses = [
                row[1], row[2], row[3], row[4], row[5],
                row[6], row[7], row[8], row[9], row[10]
            ]
            return responses

    except mysql.connector.Error as err:
        print(f"Error connecting to the database: {err}")

    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

    return None

def analyze_skin_type(responses_json):
    responses = json.loads(responses_json)
    # Calculate scores for each skin type
    skin_type_scores = {
        "dry": 0,
        "normal": 0,
        "oily": 0,
        "sensitive": 0,
        "combination": 0,
        "acne-prone":0
    }

    # Apply weights based on assigned values
    for idx, answer in enumerate(responses):
        weight = get_weight_for_question(idx + 1, answer)  # Question numbers start from 1
        skin_types = get_associated_skin_types(idx + 1, answer)
        for skin_type in skin_types:
            skin_type_scores[skin_type] += weight

    # Interpret results and provide feedback
    most_likely_type = max(skin_type_scores, key=skin_type_scores.get)
    return most_likely_type


# Get the weight for a given question and answer
def get_weight_for_question(question_number, answer):
    # Implement logic based on assigned weights (high: 2, medium: 1, low: 0.5)
    # Example:
    if question_number == 1 and answer == "a":
        return 2
    elif question_number == 1 and answer == "b":
        return 1
    elif question_number == 1 and answer == "c":
        return 2
    elif question_number == 2 and answer == "a":
        return 1
    elif question_number == 2 and answer == "b":
        return 1
    elif question_number == 2 and answer == "c":
        return 2
    elif question_number == 3 and answer == "a":
        return 2
    elif question_number == 3 and answer == "b":
        return 1
    elif question_number == 3 and answer == "c":
        return 0.5
    elif question_number == 4 and answer == "a":
        return 1
    elif question_number == 4 and answer == "b":
        return 0.5
    elif question_number == 4 and answer == "c":
        return 1
    elif question_number == 5 and answer == "a":
        return 2
    elif question_number == 5 and answer == "b":
        return 1
    elif question_number == 5 and answer == "c":
        return 2
    elif question_number == 6 and answer == "a":
        return 2
    elif question_number == 6 and answer == "b":
        return 1
    elif question_number == 6 and answer == "c":
        return 2
    elif question_number == 7 and answer == "a":
        return 2
    elif question_number == 7 and answer == "b":
        return 1
    elif question_number == 7 and answer == "c":
        return 1
    elif question_number == 8 and answer == "a":
        return 1
    elif question_number == 8 and answer == "b":
        return 0.5
    elif question_number == 8 and answer == "c":
        return 1
    elif question_number == 9 and answer == "a":
        return 2
    elif question_number == 9 and answer == "b":
        return 1
    elif question_number == 9 and answer == "c":
        return 2
    elif question_number == 10 and answer == "a":
        return 2
    elif question_number == 10 and answer == "b":
        return 1
    else: 
        return 2

# Get associated skin types for a question and answer
def get_associated_skin_types(question_number, answer):
    # Implement logic based on decision tree and questionnaire
    # Example:
    if question_number == 1 and answer == "a":
        return ["dry"]
    elif question_number == 1 and answer == "b":
        return ["normal","combination"]
    elif question_number == 1 and answer == "c":
        return ["oily"]
    elif question_number == 2 and answer == "a":
        return ["normal","dry"]
    elif question_number == 2 and answer == "b":
        return ["combination"]
    elif question_number == 2 and answer == "c":
        return ["oily","acne-prone"]
    elif question_number == 3 and answer == "a":
        return ["sensitive"]
    elif question_number == 3 and answer == "b":
        return ["normal"]
    elif question_number == 3 and answer == "c":
        return ["oily"]
    elif question_number == 4 and answer == "a":
        return ["dry"]
    elif question_number == 4 and answer == "b":
        return ["normal","combination"]
    elif question_number == 4 and answer == "c":
        return ["oily","combination"]
    elif question_number == 5 and answer == "a":
        return ["oily","acne-prone"]
    elif question_number == 5 and answer == "b":
        return ["normal","combination"]
    elif question_number == 5 and answer == "c":
        return ["oily"]
    elif question_number == 6 and answer == "a":
        return ["dry"]
    elif question_number == 6 and answer == "b":
        return ["normal","combination"]
    elif question_number == 6 and answer == "c":
        return ["oily"]
    elif question_number == 7 and answer == "a":
        return ["sensitive"]
    elif question_number == 7 and answer == "b":
        return ["normal","combination"]
    elif question_number == 7 and answer == "c":
        return ["oily","acne-prone"]
    elif question_number == 8 and answer == "a":
        return ["dry"]
    elif question_number == 8 and answer == "b":
        return ["normal","combination"]
    elif question_number == 8 and answer == "c":
        return ["oily","combination"]
    elif question_number == 9 and answer == "a":
        return ["dry"]
    elif question_number == 9 and answer == "b":
        return ["normal","combination"]
    elif question_number == 9 and answer == "c":
        return ["oily"]
    elif question_number == 10 and answer == "a":
        return ["dry"]
    elif question_number == 10 and answer == "b":
        return ["normal"]
    else: 
        return ["oily"]

if __name__ == "__main__":
    # Get username from command line arguments
    if len(sys.argv) != 3:
        print("Usage: python analyze_skin_type.py <username>")
        sys.exit(1)
    
    username = sys.argv[2]

    # Fetch responses from the database
    responses = fetch_responses(username)

    if responses:
        responses_json = json.dumps(responses)  # Convert list to JSON string
        result = analyze_skin_type(responses_json)  # Pass JSON string to the function
        print(result,end="")  # Print the skin type analysis result
    else:
        print("No responses found in the database for the user.")