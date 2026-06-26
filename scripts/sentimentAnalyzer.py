import sys
import json

from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

analyzer = SentimentIntensityAnalyzer()

# Receive input from Laravel
text = sys.stdin.read().strip()

sentences = text.split("\n")
output = []

for s in sentences:
    if s.strip() == "":
        continue
    score = analyzer.polarity_scores(s)
    output.append({
        "sentence": s,
        "scores": score
        })
print(json.dumps(output))