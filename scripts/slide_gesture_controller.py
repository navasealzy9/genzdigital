#!/usr/bin/env python3
"""
=============================================================================
GenZ Digital - AI Hand & Arm Gesture Slide Controller (Python Edition)
=============================================================================
Use your webcam to control Slides (Next / Previous) using Google MediaPipe
and OpenCV. This script globally presses Left / Right Arrow keys on your computer.

Install requirements:
    pip install opencv-python mediapipe pyautogui

Run:
    python scripts/slide_gesture_controller.py

Controls:
    ☝️  1 Finger (Index Up)       -> Previous Slide (Left Arrow)
    ✌️  2 Fingers (Peace / V)     -> Next Slide (Right Arrow)
    ✋  Open Palm                 -> Standby / Ready
    [Q] Press 'q' in video window -> Quit
=============================================================================
"""

import time
import sys

try:
    import cv2
    import mediapipe as mp
    import pyautogui
except ImportError as e:
    print("\n[!] Missing dependencies. Please run:")
    print("    pip install opencv-python mediapipe pyautogui\n")
    sys.exit(1)

# Disable PyAutoGUI fail-safe pause for instant response
pyautogui.PAUSE = 0.05

def main():
    print("=" * 65)
    print("  GenZ Digital - AI Gesture Controller Running")
    print("  ☝️  1 Finger  : Previous Slide (Left Arrow)")
    print("  ✌️  2 Fingers : Next Slide (Right Arrow)")
    print("  Press 'q' in the camera window to exit.")
    print("=" * 65)

    mp_hands = mp.solutions.hands
    mp_draw = mp.solutions.drawing_utils
    mp_styles = mp.solutions.drawing_styles

    hands = mp_hands.Hands(
        static_image_mode=False,
        max_num_hands=1,
        min_detection_confidence=0.7,
        min_tracking_confidence=0.65
    )

    cap = cv2.VideoCapture(0)
    if not cap.isOpened():
        print("[!] Cannot open webcam. Please check your camera connection.")
        return

    # Tracking state
    last_action_time = 0.0
    COOLDOWN = 1.3  # Seconds between slide flips to prevent duplicate triggers
    hold_type = None
    hold_frames = 0
    REQUIRED_HOLD_FRAMES = 3

    while cap.isOpened():
        success, frame = cap.read()
        if not success:
            continue

        # Flip frame horizontally for natural selfie view
        frame = cv2.flip(frame, 1)
        h, w, c = frame.shape

        # Convert to RGB for MediaPipe
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = hands.process(rgb_frame)

        status_text = "Ready (Raise hand to camera)"
        status_color = (200, 200, 200)

        if results.multi_hand_landmarks:
            for hand_landmarks in results.multi_hand_landmarks:
                # Draw skeleton connections
                mp_draw.draw_landmarks(
                    frame,
                    hand_landmarks,
                    mp_hands.HAND_CONNECTIONS,
                    mp_styles.get_default_hand_landmarks_style(),
                    mp_styles.get_default_hand_connections_style()
                )

                lm = hand_landmarks.landmark

                # Determine finger extensions (Y goes down in image coordinates)
                index_up = lm[8].y < lm[6].y
                middle_up = lm[12].y < lm[10].y
                ring_up = lm[16].y < lm[14].y
                pinky_up = lm[20].y < lm[18].y

                current_gesture = None

                # 1 Finger: Index Up only
                if index_up and not middle_up and not ring_up and not pinky_up:
                    current_gesture = 1
                    status_text = "Detected: 1 Finger (PREVIOUS SLIDE)"
                    status_color = (0, 200, 255) # Yellow/Orange

                # 2 Fingers: Index + Middle Up
                elif index_up and middle_up and not ring_up and not pinky_up:
                    current_gesture = 2
                    status_text = "Detected: 2 Fingers (NEXT SLIDE)"
                    status_color = (0, 255, 100) # Green

                elif index_up and middle_up and ring_up and pinky_up:
                    status_text = "Open Palm (Standby)"
                    status_color = (255, 200, 0) # Cyan

                else:
                    status_text = "Hand Detected (Tracking)"
                    status_color = (180, 180, 180)

                # Process trigger with hold stability and debounce cooldown
                now = time.time()
                if current_gesture in (1, 2):
                    if hold_type == current_gesture:
                        hold_frames += 1
                        if hold_frames >= REQUIRED_HOLD_FRAMES and (now - last_action_time) > COOLDOWN:
                            if current_gesture == 1:
                                pyautogui.press('left')
                                print("[<-] Action: Previous Slide (Left Arrow)")
                            elif current_gesture == 2:
                                pyautogui.press('right')
                                print("[->] Action: Next Slide (Right Arrow)")
                            last_action_time = now
                            hold_frames = 0
                    else:
                        hold_type = current_gesture
                        hold_frames = 1
                else:
                    hold_type = None
                    hold_frames = 0

        # Draw HUD on screen
        cv2.rectangle(frame, (0, 0), (w, 50), (15, 23, 42), -1)
        cv2.putText(frame, status_text, (15, 33), cv2.FONT_HERSHEY_SIMPLEX, 0.75, status_color, 2)

        cv2.imshow("GenZ Digital - AI Gesture Controller", frame)

        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    main()
