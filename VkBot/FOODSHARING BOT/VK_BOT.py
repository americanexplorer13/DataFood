import vk_api
import random
from vk_api.bot_longpoll import VkBotLongPoll, VkBotEventType
from vk_api.keyboard import VkKeyboard, VkKeyboardColor
import asyncio
import re
import threading
import requests

random.seed()  # рандомайзер

user_ids = [122509071]
donor_list = {122509071: {'city': 'новосибирск', 'rating': 5, 'queues_list': [{'queue_id': 212, 'queue_text': 'Отдаю за ненадобностью трубочки вкусные срок не вышел\nметки: {сладости}', 'photo_id': "-187934041_457239071"}, {'queue_id': 213, 'queue_text': 'Отдам даром. Каша вскрытая, почти полная\nкаша: {крупы}', 'photo_id': "-187934041_457239034"}]}}
public_city = {'москва': ['https://vk.com/sharingfood', 'https://vk.com/foodsharing_msk'], 'новосибирск': ['https://vk.com/nsk_foodsharing'], 'питер': ['https://vk.com/sharingfood', 'https://vk.com/foodsharing_spb']}

class bot_interface:
    def __init__(self):
        pass

    def main_script(self, event):
        if event.object['message']['text'].lower().find('донор') != -1:
            vk.messages.send(peer_id=event.object['message']['from_id'], random_id=random.randint(1, 255), keyboard=self.keyboard_main().get_keyboard(),
                             message="Чтобы оставить заявку как донор, напишите нам следующую информацию: ")
            threading.Thread(target=self.create_queue, args=(event.object['message']['from_id'], )).start()

        elif event.object['message']['text'].lower().find('помощь') != -1:
            vk.messages.send(peer_id=event.object['message']['from_id'], random_id=random.randint(1, 255), keyboard=self.keyboard_main().get_keyboard(),
                             message=" Фудшеринг — это практика распределения продуктов питания, как правило с истекающим сроком годности, между членами сообщества с помощью специальных организаций или онлайн-платформ.\n\nМы видим по твоему профилю что ты из {}!\nМы предлагаем вам сразу перейти по вот этим ссылкам:{}".format(donor_list[event.object['message']['from_id']]['city'].title(), public_city[donor_list[event.object['message']['from_id']]['city']]))

        elif event.object['message']['text'].lower().find('забрать') != -1:
            vk.messages.send(peer_id=event.object['message']['from_id'], random_id=random.randint(1, 255), keyboard=self.keyboard_queue_nav().get_keyboard(),
                             message="Супер! Давайте посмотрим что мы для вас нашли: ")
            self.show_all_queues(event.object['message']['from_id'])
        else:
            pass

    @staticmethod
    def create_queue(user_id):
        for event in longpoll.listen():
            if event.type == VkBotEventType.MESSAGE_NEW:
                txt = event.object['message']['text'].lower()

                SQL_response = requests.get('http://stepanev.beget.tech/InsertFoodPosition.php')
                print('http://stepanev.beget.tech/InsertFoodPosition.php ' + str(SQL_response))

                donor_list[user_id]['queues_list'].append({'queue_id': 214, 'queue_text': txt, 'photo_id': "-196459619_457239018"})
                vk.messages.send(peer_id=user_id, random_id=random.randint(1, 255), message="Заявка успешно создана!")
                return 0

    @staticmethod
    def show_all_queues(user_id):

        SQL_response = requests.get('http://stepanev.beget.tech/GetCityList.php')
        print("http://stepanev.beget.tech/GetCityList.php " + str(SQL_response))

        donor_queue = donor_list[user_id]['queues_list']
        for i in donor_queue:
            vk.messages.send(peer_id=user_id, random_id=random.randint(1, 255), attachment=str("photo" + i['photo_id']), message=str(i['queue_text'] + '\n' + 'Рейтинг пользователя: ' + str(random.randint(1, 5)) + '/5'))
        return 0

    @staticmethod
    def user_exist(user_id):
        for i in user_ids:
            if i == user_id:
                return True
        return False

    @staticmethod
    def keyboard_main():
        keyboard = VkKeyboard(one_time=False)
        keyboard.add_button('Стать донором и Создать заявку', color=VkKeyboardColor.DEFAULT)
        keyboard.add_line()  # Переход на вторую строку
        keyboard.add_button('Просмотреть заявки и Забрать еду', color=VkKeyboardColor.DEFAULT)
        keyboard.add_line()  # Переход на вторую строку
        keyboard.add_button('Помощь', color=VkKeyboardColor.PRIMARY)
        return keyboard

    @staticmethod
    def keyboard_queue_nav():
        keyboard = VkKeyboard(one_time=False)
        keyboard.add_button('Назад', color=VkKeyboardColor.NEGATIVE)
        keyboard.add_button('Вперед', color=VkKeyboardColor.POSITIVE)
        keyboard.add_line()  # Переход на вторую строку
        keyboard.add_button('Стать донором и Создать заявку', color=VkKeyboardColor.DEFAULT)
        keyboard.add_line()  # Переход на вторую строку
        keyboard.add_button('Просмотреть заявки и Забрать еду', color=VkKeyboardColor.DEFAULT)
        keyboard.add_line()  # Переход на вторую строку
        keyboard.add_button('Помощь', color=VkKeyboardColor.PRIMARY)
        return keyboard

async def main():
    bot = bot_interface()
    for event in longpoll.listen():
        if event.type == VkBotEventType.MESSAGE_NEW:
            print(event.object)
            message = event.object['message']
            if bot.user_exist(message['from_id']):
                bot.main_script(event=event)
            else:
                if message['text'].lower().find('запи') != -1:
                    user_ids.append(message['from_id'])

                    SQL_response = requests.post("http://stepanev.beget.tech/InsertCity.php")
                    print("http://stepanev.beget.tech/InsertCity.php " + str(SQL_response))

                    donor_list.update({message['from_id']: {'city': message['text'].lower().split(" ")[1], 'rating': 5, 'queues_list': []}})
                    vk.messages.send(peer_id=message['from_id'], random_id=random.randint(1, 255), keyboard=bot.keyboard_main().get_keyboard(),
                                     message="Я успешно тебя записал к нам! Добро пожаловать")
                else:
                    vk.messages.send(peer_id=message['from_id'], random_id=random.randint(1, 255), keyboard=bot.keyboard_main().get_keyboard(),
                                     message="Упс, похоже тебя нет в нашей базе данных, но я могу записать тебя если ты хочешь! Напиши слово \"записать\" а потом информацию о том где ты проживаешь!\n\nПример: запишите Барнаул")


if __name__ == '__main__':
    vk_session = vk_api.VkApi(token='494d4ef6c282c2fdca5cf545079c6f49954f132ebb653a2ac1a5ebbb145f7444d0199f6936f6df696fad2')  # ввод токена группы
    longpoll = VkBotLongPoll(vk_session, '196459619')  # не помню че такое скорее всего запуск сессии VK
    vk = vk_session.get_api()  # получаем API VK

    print("[VK_BOT]: БОТ ЗАПУЩЕН")

    loop = asyncio.get_event_loop()
    loop.run_until_complete(main())
