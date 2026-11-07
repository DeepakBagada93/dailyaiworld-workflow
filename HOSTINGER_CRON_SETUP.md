# Daily AI World — Hostinger Cloud Cron Job Configuration

Use this guide to set up the daily automated Google & IndexNow indexing cron job on Hostinger hPanel without copy-paste or spacing errors.

---

## 1. Schedule / Timing Settings

> **Time Target:** Every day at **3:00 PM IST** (15:00 IST)  
> **Server Timezone:** UTC (`IST - 5h 30m`)  
> **Hostinger UTC Time:** **09:30 UTC**

### If Hostinger has 5 Timing Input Boxes:
* **Minute:** `30`
* **Hour:** `9`
* **Day of Month:** `*`
* **Month:** `*`
* **Day of Week:** `*`

### Standard Cron Expression:
```text
30 9 * * *
```

---

## 2. Command to Run

Copy the exact single line below (do **not** insert any extra spaces or line breaks):

```bash
/usr/bin/php /home/u775719140/domains/dailyaiworld.com/public_html/scripts/run_compliant_indexing_cron.php >> /home/u775719140/domains/dailyaiworld.com/public_html/storage/logs/google_indexing_cron.log 2>&1
```

---

## 3. Step-by-Step in Hostinger hPanel

1. Log in to [hpanel.hostinger.com](https://hpanel.hostinger.com).
2. Go to **Websites** -> Click **Manage** next to **dailyaiworld.com**.
3. In the left navigation menu, search for **Cron Jobs** (or navigate to **Advanced -> Cron Jobs**).
4. Under **Create New Cron Job**:
   * **Type:** Select **Custom**
   * **Command to run:** Paste the command from Section 2 above.
   * **Minute:** `30`
   * **Hour:** `9`
   * **Day:** `*`
   * **Month:** `*`
   * **Weekday:** `*`
5. Click **Save** / **Add**.

---

## 4. How to Verify the Logs

Whenever you want to check the latest indexing results from Hostinger:

```bash
ssh -i ~/.ssh/hostinger_deepak -p 65002 u775719140@86.38.243.124 "tail -n 30 domains/dailyaiworld.com/public_html/storage/logs/google_indexing_cron.log"
```

Expected log entry every day at 3:00 PM IST:
```text
[YYYY-MM-DD 15:00:01 IST] COMPLIANT_INDEXING_CRON: Success=196 | Failed=0 | Total=196
```
