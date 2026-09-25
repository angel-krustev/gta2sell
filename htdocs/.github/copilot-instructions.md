# Tool & Path Formatting Rules
- Always use POSIX-style relative paths from workspace root (e.g., `web/eml.php`) or forward slashes (`/`).
- Never use Windows backslashes (`\`) in paths or tool call arguments.
- When calling file operations or shell commands, format them for a Bash/Git Bash environment.

