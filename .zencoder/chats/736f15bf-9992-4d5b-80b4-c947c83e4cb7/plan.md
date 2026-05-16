# Spec and build

## Agent Instructions

Ask the user questions when anything is unclear or needs their input. This includes:

- Ambiguous or incomplete requirements
- Technical decisions that affect architecture or user experience
- Trade-offs that require business context

Do not make assumptions on important decisions — get clarification first.

---

## Workflow Steps

### [x] Step: Technical Specification

Assess the task's difficulty, as underestimating it leads to poor outcomes.

- easy: Straightforward implementation, trivial bug fix or feature
- medium: Moderate complexity, some edge cases or caveats to consider
- hard: Complex logic, many caveats, architectural considerations, or high-risk changes

Create a technical specification for the task that is appropriate for the complexity level:

- Review the existing codebase architecture and identify reusable components.
- Define the implementation approach based on established patterns in the project.
- Identify all source code files that will be created or modified.
- Define any necessary data model, API, or interface changes.
- Describe verification steps using the project's test and lint commands.

Save the output to `/home/charmaine/Documents/Charmaine/Assessment/policy_management_system/.zencoder/chats/736f15bf-9992-4d5b-80b4-c947c83e4cb7/spec.md` with:

- Technical context (language, dependencies)
- Implementation approach
- Source code structure changes
- Data model / API / interface changes
- Verification approach

If the task is complex enough, create a detailed implementation plan based on `/home/charmaine/Documents/Charmaine/Assessment/policy_management_system/.zencoder/chats/736f15bf-9992-4d5b-80b4-c947c83e4cb7/spec.md`:

- Break down the work into concrete tasks (incrementable, testable milestones)
- Each task should reference relevant contracts and include verification steps
- Replace the Implementation step below with the planned tasks

Rule of thumb for step size: each step should represent a coherent unit of work (e.g., implement a component, add an API endpoint, write tests for a module). Avoid steps that are too granular (single function).

Save to `/home/charmaine/Documents/Charmaine/Assessment/policy_management_system/.zencoder/chats/736f15bf-9992-4d5b-80b4-c947c83e4cb7/plan.md`. If the feature is trivial and doesn't warrant this breakdown, keep the Implementation step below as is.

**Stop here.** Present the specification (and plan, if created) to the user and wait for their confirmation before proceeding.

---

### [x] Step: Implementation

#### [x] Task 1: Update Policy model
Update `backend/app/Models/Policy.php` to fix relationship names and foreign keys to align with the database schema and views.
- Rename `policyType` to `type`.
- Fix `client` relation to use `user_id`.
- Verification: `php -l backend/app/Models/Policy.php`

#### [x] Task 2: Refactor PolicyController
Major cleanup of `backend/app/Http/Controllers/PolicyController.php`.
- Add `__construct` for middleware.
- Consolidate `store` methods and fix logic.
- Align `index`, `create`, `show`, `edit`, `update`, and `destroy` with the schema.
- Fix syntax errors and broken validation calls.
- Verification: `php -l backend/app/Http/Controllers/PolicyController.php`

#### [x] Task 3: Final Verification
Perform manual and automated verification.
- Verify policy registry loads correctly.
- Test full CRUD lifecycle for policies.
- Run `php artisan test` if tests exist.
- Verification: All CRUD operations work without errors.

#### [x] Task 4: Post-Implementation Report
Write a report to `/home/charmaine/Documents/Charmaine/Assessment/policy_management_system/.zencoder/chats/736f15bf-9992-4d5b-80b4-c947c83e4cb7/report.md` describing:
- What was implemented
- How the solution was tested
- The biggest issues or challenges encountered
