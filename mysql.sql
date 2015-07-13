-- 1)
select student_id, sum(amount) as sum_amount from payments group by student_id order by sum_amount desc limit 1,1;

-- 2)
-- акутальные статусы студентов
select s1.student_id, s1.status from student_status as s1 inner join (select student_id, status, max(datetime) as datetime from student_status group by student_id) as s2 on s1.student_id = s2.student_id and s1.datetime = s2.datetime;

-- результат
select name, surname from student as std inner join (select s1.student_id as student_id, s1.status as status from student_status as s1 inner join (select student_id, status, max(datetime) as datetime from student_status group by student_id) as s2 on s1.student_id = s2.student_id and s1.datetime = s2.datetime where s1.status = 'vacation') as stt on std.id = stt.student_id where std.gender = 'unknown';

-- 3)
-- акутальные статусы студентов, которые бросили учебу
select s1.student_id, s1.status from student_status as s1 inner join (select student_id, status, max(datetime) as datetime from student_status group by student_id) as s2 on s1.student_id = s2.student_id and s1.datetime = s2.datetime where s1.status = 'lost';

-- студенты, совершившие менее трех платежей (amount = 0 не учитываются)
select student_id from (select student_id, count(*) as cnt from (select student_id, amount from payments where amount > 0) as nonzero_payments group by student_id) as num_of_payments_per_student where cnt <= 3;

-- результат
select std.id, std.name, std.surname from student as std inner join
(
  select payed_less_than_three_times_students.student_id from
  (
    select
      student_id
    from
    (
      select
        student_id,
        count(*) as cnt
      from
      (
        select
          student_id,
          amount
        from
          payments
        where
          amount > 0
      ) as nonzero_payments group by student_id
    )
    as num_of_payments_per_student where cnt <= 3
  ) as payed_less_than_three_times_students
inner join
  (
    select
      s1.student_id as student_id,
      s1.status as status
    from
      student_status as s1
    inner join
    (
      select
        student_id,
        status,
        max(datetime) as datetime
      from
        student_status
      group by student_id
    ) as s2
    on
      s1.student_id = s2.student_id and s1.datetime = s2.datetime
    where s1.status = 'lost'
  ) as lost_students
on
  payed_less_than_three_times_students.student_id = lost_students.student_id
) as result_students
on std.id = result_students.student_id;
