---
applyTo: "src/Entity/**/*.php"
---

# Doctrine Entity Conventions — MaliCart

- Use **PHP 8 attributes** for all Doctrine mapping. Never use XML or YAML mapping.
- `User` uses a **UUID** primary key (`Symfony\Uid\Uuid`). All other entities use `INT` auto-increment.
- `ShopProduct.price` is an **integer (cents)**. Always store/retrieve as int; format for display only in Twig (`{{ product.price / 100 | number_format(2) }}`).
- `OrderDetails.product` is a **string snapshot** of the product name at order time — intentionally not a foreign key.
- `User.avatar` is auto-assigned from the DiceBear API in a `#[ORM\PrePersist]` lifecycle callback — do not overwrite it in fixtures or seeds.
- Lifecycle hooks (`PrePersist`, `PreUpdate`) must use `#[ORM\HasLifecycleCallbacks]` on the class and `#[ORM\PrePersist]` / `#[ORM\PreUpdate]` on methods.
- After modifying any entity, generate a migration: `php bin/console make:migration` then `php bin/console doctrine:migrations:migrate`.
- Slug fields must match regex `[a-z0-9-]+` (validated via `#[Assert\Regex]`).
- M:N relations between `ShopProduct` ↔ `ShopProductColor` and `ShopProduct` ↔ `ShopProductSize` — owning side is `ShopProduct`.
