---
applyTo: "src/Controller/**/*.php"
---

# Controller Conventions — MaliCart

- **Routing**: always use PHP 8 attribute syntax: `#[Route('/path', name: 'domain.action')]`
- **Route name format**: `<domain>.<action>` — e.g., `cart.index`, `account.info`, `order.checkout`
- **Admin controllers** (`src/Controller/Admin/`) must extend `AbstractCrudController` (EasyAdmin 4) or `AbstractDashboardController`; never declare manual routes on admin CRUDs.
- **Template paths**: mirror the controller name in lowercase — `CartController` → `templates/cart/`, `AccountController` → `templates/account/`
- **Protected routes**: `/account/*` and `/order/*` require `ROLE_USER`; enforce via `security.yaml` access_control, not inside the controller method.
- **Cart access**: inject `CartManager` (service) to read/write the session cart (key: `'panier'`). Do not access `$_SESSION` directly.
- **Form handling pattern**:
  ```php
  $form = $this->createForm(FooType::class, $entity);
  $form->handleRequest($request);
  if ($form->isSubmitted() && $form->isValid()) { ... }
  ```
- **Redirects after POST**: always redirect to a named route (`$this->redirectToRoute('domain.action')`), never render on POST.
