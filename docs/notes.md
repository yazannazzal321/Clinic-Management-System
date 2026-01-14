# Technical Notes

## Docker Issue
The application initially failed to connect to MySQL because PHP extensions were missing.

## Solution
Installed mysqli and PDO extensions in the Dockerfile.

## Git Lesson
Meaningful commits and small changes make the repository easier to understand.

## Deployment Experience – Assignment 3

### Challenges Faced
- Docker port conflicts on local machine.
- Database was not created initially on VPS.
- Environment variables configuration required careful matching.

### How I Solved Them
- Changed MySQL port mapping to avoid conflicts.
- Created the database manually using MySQL terminal.
- Used environment variables (DB_HOST, DB_USER, DB_PASS, DB_NAME) in the application.

### Outcome
The application was successfully deployed on a VPS using Docker containers and connected to a remote MySQL database.
