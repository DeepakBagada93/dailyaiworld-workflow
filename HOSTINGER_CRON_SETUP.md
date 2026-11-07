# Daily AI World — Hostinger Cloud Cron Job Configuration

Use this guide to set up the daily automated Google & IndexNow indexing cron job on Hostinger hPanel with zero errors.

---

> [!CAUTION]
> ### 🛑 Critical Errors to Avoid in Hostinger:
> 1. **DO NOT write `bash` at the beginning!**  
>    ❌ `bash /usr/bin/php ...` → **FAILS** with error: `/usr/bin/php: cannot execute binary file`.  
>    ✅ Start directly with `/usr/bin/php`.
> 2. **DO NOT use `0,30` for minutes!**  
>    ❌ `0,30 9 * * *` → Runs twice a day (at 2:30 PM AND 3:00 PM).  
>    ✅ Use `30 9 * * *` → Runs exactly once daily at **3:00 PM IST**.
> 3. **DO NOT add spaces inside file paths!**  
>    ❌ `.../run_compliant_indexing_cro n.php` → **FAILS** with file not found.  
>    ✅ `.../run_compliant_indexing_cron.php`

---

## 1. Quick Copy Settings

| Field in Hostinger | Value to Enter | Notes |
| :--- | :--- | :--- |
| **Type** | **Custom** | Select Custom Cron Job |
| **Time Format** | **`30 9 * * *`** | Runs daily at **3:00 PM IST** (09:30 UTC) |
| **Minute** | **`30`** | Exactly 30 (not `0,30`) |
| **Hour** | **`9`** | 9 AM UTC = 3:00 PM IST |
| **Day of Month** | **`*`** | Every day |
| **Month** | **`*`** | Every month |
| **Day of Week** | **`*`** | Every day of the week |

---

## 2. Exact Command to Run (Copy & Paste)

Copy the single line below (starts with `/usr/bin/php` — **no `bash`**):

```bash
/usr/bin/php /home/u775719140/domains/dailyaiworld.com/public_html/scripts/run_compliant_indexing_cron.php >> /home/u775719140/domains/dailyaiworld.com/public_html/storage/logs/google_indexing_cron.log 2>&1
```

---

## 3. Side-by-Side Verification Check

| Config | ❌ Wrong (Will Break) | ✅ Correct (Works 100%) |
| :--- | :--- | :--- |
| **Command Prefix** | `bash /usr/bin/php ...` | `/usr/bin/php ...` |
| **Minute** | `0,30` *(runs twice)* | `30` *(runs once)* |
| **File Names** | `cro n.php` / `cron. log` | `cron.php` / `cron.log` |
| **Time Result** | Runs 2:30 PM & 3:00 PM | Runs **3:00 PM IST** daily |

---

## 4. Step-by-Step in Hostinger hPanel

1. Log in to [hpanel.hostinger.com](https://hpanel.hostinger.com).
2. Go to **Websites** → Click **Manage** next to **dailyaiworld.com**.
3. In the left navigation menu, search for **Cron Jobs** (or go to **Advanced → Cron Jobs**).
4. If an old or incorrect cron job exists under **Manage Existing Cron Jobs**, click **Delete**.
5. Under **Create New Cron Job**:
   * **Type:** Select **Custom**
   * **Command to run:** Paste the exact command from Section 2 above.
   * **Minute:** `30`
   * **Hour:** `9`
   * **Day:** `*`
   * **Month:** `*`
   * **Weekday:** `*`
6. Click **Save** (or **Add**).

---

## 5. How to Check Live Logs Anytime via Terminal

Run this command anytime from your Mac to see the latest execution output on Hostinger:

```bash
ssh -i ~/.ssh/hostinger_deepak -p 65002 u775719140@86.38.243.124 "tail -n 25 domains/dailyaiworld.com/public_html/storage/logs/google_indexing_cron.log"
```

Expected log entry every day at 3:00 PM IST:
```text
[YYYY-MM-DD 15:00:01 IST] COMPLIANT_INDEXING_CRON: Success=196 | Failed=0 | Total=196
```
