# Work It Out
##### A system for scheduling workouts

## How It Works
1. Track which sports/areas you want to train (ex: running & rock climbing)
2. Setup your standard weekly workouts
3. Add upcoming races/events to the calendar with training specific to the event
4. View your calendar with the upcoming training plan overriding any default workouts for that sport

## Installation
1. Create a new table in your MySQL DB
2. Import the database structure from `DB.sql`
2. Update the parameters in `config example.ini`
3. Rename `config example.ini` to `config.ini`
4. Place the code on a server capable of running PHP 8
5. Navigate to the `public` directory to access the website

## TODO
  - Make SSO optional
  - Support manging multiple users per instance